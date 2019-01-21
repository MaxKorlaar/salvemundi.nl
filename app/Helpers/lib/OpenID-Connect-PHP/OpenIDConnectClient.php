<?php

    /**
     *
     * Copyright MITRE 2015
     *
     * OpenIDConnectClient for PHP5
     * Author: Michael Jett <mjett@mitre.org>
     *
     * Licensed under the Apache License, Version 2.0 (the "License"); you may
     * not use this file except in compliance with the License. You may obtain
     * a copy of the License at
     *
     *      http://www.apache.org/licenses/LICENSE-2.0
     *
     * Unless required by applicable law or agreed to in writing, software
     * distributed under the License is distributed on an "AS IS" BASIS, WITHOUT
     * WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied. See the
     * License for the specific language governing permissions and limitations
     * under the License.
     *
     */

    /**
     *
     * JWT signature verification support by Jonathan Reed <jdreed@mit.edu>
     * Licensed under the same license as the rest of this file.
     *
     * phpseclib is required to validate the signatures of some tokens.
     * It can be downloaded from: http://phpseclib.sourceforge.net/
     */

    //    include('Crypt/RSA.php');
    //    if (!class_exists('Crypt_RSA')) {
    //        user_error('Unable to find phpseclib Crypt/RSA.php.  Ensure phpseclib is installed and in include_path');
    //    }

    /**
     * A wrapper around base64_decode which decodes Base64URL-encoded data,
     * which is not the same alphabet as base64.
     *
     * @param $base64url
     *
     * @return bool|string
     */
    function base64url_decode($base64url) {
        return base64_decode(b64url2b64($base64url));
    }

    /**
     * Per RFC4648, "base64 encoding with URL-safe and filename-safe
     * alphabet".  This just replaces characters 62 and 63.  None of the
     * reference implementations seem to restore the padding if necessary,
     * but we'll do it anyway.
     *
     * @param $base64url
     *
     * @return string
     */
    function b64url2b64($base64url) {
        // "Shouldn't" be necessary, but why not
        $padding = strlen($base64url) % 4;
        if ($padding > 0) {
            $base64url .= str_repeat("=", 4 - $padding);
        }
        return strtr($base64url, '-_', '+/');
    }


    /**
     * OpenIDConnect Exception Class
     */
    class OpenIDConnectClientException extends Exception {

    }

    /**
     * Require the CURL and JSON PHP extentions to be installed
     */
    if (!function_exists('curl_init')) {
        throw new OpenIDConnectClientException('OpenIDConnect needs the CURL PHP extension.');
    }
    if (!function_exists('json_decode')) {
        throw new OpenIDConnectClientException('OpenIDConnect needs the JSON PHP extension.');
    }

    /**
     *
     * Please note this class stores nonces in $_SESSION['openid_connect_nonce']
     *
     */
    class OpenIDConnectClient {

        /**
         * @var string arbitrary id value
         */
        private $clientID;

        /*
         * @var string arbitrary name value
         */
        private $clientName;

        /**
         * @var string arbitrary secret value
         */
        private $clientSecret;

        /**
         * @var array holds the provider configuration
         */
        private $providerConfig = [];

        /**
         * @var string http proxy if necessary
         */
        private $httpProxy;

        /**
         * @var string full system path to the SSL certificate
         */
        private $certPath;

        /**
         * @var string if we aquire an access token it will be stored here
         */
        private $accessToken;

        /**
         * @var string if we aquire a refresh token it will be stored here
         */
        private $refreshToken;

        /**
         * @var array holds scopes
         */
        private $scopes = [];

        /**
         * @var array holds a cache of info returned from the user info endpoint
         */
        private $userInfo = [];

        /**
         * @var array holds authentication parameters
         */
        private $authParams = [];

        /**
         * @param $provider_url  string optional
         *
         * @param $client_id     string optional
         * @param $client_secret string optional
         *
         */
        public function __construct($provider_url = null, $client_id = null, $client_secret = null) {
            $this->setProviderURL($provider_url);
            $this->clientID     = $client_id;
            $this->clientSecret = $client_secret;
        }

        /**
         * @param $provider_url
         */
        public function setProviderURL($provider_url) {
            $this->providerConfig['issuer'] = $provider_url;
        }

        /**
         * @return bool
         * @throws OpenIDConnectClientException
         */
        public function authenticate() {

            // Do a preemptive check to see if the provider has thrown an error from a previous redirect
            if (isset($_REQUEST['error'])) {
                if ($_REQUEST['error'] === 'access_denied') {
                    throw new OpenIDConnectClientException('Access denied', 403);
                }
                throw new OpenIDConnectClientException("Error: " . $_REQUEST['error'] . " Description: " . $_REQUEST['error_description']);
            }

            // If we have an authorization code then proceed to request a token
            if (isset($_REQUEST["code"])) {

                $code       = $_REQUEST["code"];
                $token_json = $this->requestTokens($code);
                // Throw an error if the server returns one
                if (isset($token_json->error)) {
                    throw new OpenIDConnectClientException(json_encode($token_json));
                }

                // Do an OpenID Connect session check
                if ($_REQUEST['state'] != \Illuminate\Support\Facades\Session::get('openid_connect_state')) {
                    \Illuminate\Support\Facades\Log::error('Kon state niet opvragen bij inloggen', [
                        'request' => request()->all(),
                        'state'   => \Illuminate\Support\Facades\Session::get('openid_connect_state')
                    ]);
                    throw new OpenIDConnectClientException("Unable to determine state");
                }

                if (!property_exists($token_json, 'id_token')) {
                    throw new OpenIDConnectClientException("User did not authorize openid scope.");
                }

                $claims = $this->decodeJWT($token_json->id_token, 1);

                // Verify the signature
                if ($this->canVerifySignatures()) {
                    if (!$this->verifyJWTsignature($token_json->id_token)) {
                        throw new OpenIDConnectClientException ("Unable to verify signature");
                    }
                } else {
                    user_error("Warning: JWT signature verification unavailable.");
                }

                // If this is a valid claim
                if ($this->verifyJWTclaims($claims)) {

                    // Clean up the session a little
                    \Illuminate\Support\Facades\Session::pull('openid_connect_nonce');
                    \Illuminate\Support\Facades\Session::save();

                    // Save the access token
                    $this->accessToken = $token_json->access_token;

                    // Save the refresh token, if we got one
                    if (isset($token_json->refresh_token)) $this->refreshToken = $token_json->refresh_token;

                    // Success!
                    return true;

                } else {
                    throw new OpenIDConnectClientException ("Unable to verify JWT claims");
                }

            } else {

                $this->requestAuthorization();
                return false;
            }

        }

        /**
         * Requests ID and Access tokens
         *
         * @param $code
         *
         * @return mixed
         * @throws OpenIDConnectClientException
         */
        private function requestTokens($code) {


            $token_endpoint = $this->getProviderConfigValue("token_endpoint");
            $grant_type     = "authorization_code";

            $token_params = [
                'grant_type'    => $grant_type,
                'code'          => $code,
                'redirect_uri'  => $this->getRedirectURL(),
                'client_id'     => $this->clientID,
                'client_secret' => $this->clientSecret
            ];

            // Convert token params to string format
            $token_params = http_build_query($token_params, null, '&');
            return json_decode($this->fetchURL($token_endpoint, $token_params));

        }

        /**
         * Get's anything that we need configuration wise including endpoints, and other values
         *
         * @param $param
         *
         * @throws OpenIDConnectClientException
         * @return string
         *
         */
        private function getProviderConfigValue($param) {

            // If the configuration value is not available, attempt to fetch it from a well known config endpoint
            // This is also known as auto "discovery"
            if (!isset($this->providerConfig[$param])) {
                $well_known_config_url = rtrim($this->getProviderURL(), "/") . "/.well-known/openid-configuration";
                $value                 = json_decode($this->fetchURL($well_known_config_url))->{$param};

                if ($value) {
                    $this->providerConfig[$param] = $value;
                } else {
                    throw new OpenIDConnectClientException("The provider {$param} has not been set. Make sure your provider has a well known configuration available.");
                }

            }

            return $this->providerConfig[$param];
        }

        /**
         * @return string
         * @throws OpenIDConnectClientException
         */
        public function getProviderURL() {

            if (!isset($this->providerConfig['issuer'])) {
                throw new OpenIDConnectClientException("The provider URL has not been set");
            } else {
                return $this->providerConfig['issuer'];
            }
        }

        /**
         * @param       $url
         * @param null  $post_body string If this is set the post type will be POST
         * @param array $headers
         * @param bool  $addToken
         *
         * @return mixed
         * @throws OpenIDConnectClientException
         */
        public function fetchURL($url, $post_body = null, $headers = [], $addToken = false) {


            // OK cool - then let's create a new cURL resource handle
            $ch = curl_init();

            // Determine whether this is a GET or POST
            if ($post_body != null) {
                curl_setopt($ch, CURLOPT_POST, 1);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $post_body);

                // Default content type is form encoded
                $content_type = 'application/x-www-form-urlencoded';

                // Determine if this is a JSON payload and add the appropriate content type
                if (is_object(json_decode($post_body))) {
                    $content_type = 'application/json';
                }

                // Add POST-specific headers
                $headers[] = "Content-Type: {$content_type}";
                $headers[] = 'Content-Length: ' . strlen($post_body);

            }

            //             Check if the access-token is set, and add it to the headers
            if (!empty($this->accessToken) && $addToken) {
                $headers[] = "Authorization: Bearer {$this->accessToken}";
            }

            // If we set some heaers include them
            if (count($headers) > 0) {
                curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            }

            // Set URL to download
            curl_setopt($ch, CURLOPT_URL, $url);

            if (isset($this->httpProxy)) {
                curl_setopt($ch, CURLOPT_PROXY, $this->httpProxy);
            }

            // Include header in result? (0 = yes, 1 = no)
            curl_setopt($ch, CURLOPT_HEADER, 0);

            /**
             * Set cert
             * Otherwise ignore SSL peer verification
             */
            if (isset($this->certPath)) {
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
                curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
                curl_setopt($ch, CURLOPT_CAINFO, $this->certPath);
            } else {
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            }

            // Should cURL return or print out the data? (true = return, false = print)
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

            // Timeout in seconds
            curl_setopt($ch, CURLOPT_TIMEOUT, 60);
            // Download the given URL, and return output
            $output = curl_exec($ch);

            if (curl_exec($ch) === false) {
                throw new OpenIDConnectClientException('Curl error: ' . curl_error($ch));
            }
            // Close the cURL resource, and free system resources
            //            $info = curl_getinfo($ch);
            curl_close($ch);
            //            if ($info['http_code'] != 255 && $url !='https://identity.fhict.nl/connect/token' && $url !='https://identity.fhict.nl/.well-known/openid-configuration' && $url != 'https://identity.fhict.nl/.well-known/jwks' && $url != 'https://identity.fhict.nl/connect/userinfo?schema=openid' && $url != 'https://api.fhict.nl/permissions/picture_token') dd($url, $info, $output, $headers);
            return $output;
        }

        /**
         * Gets the URL of the current page we are on, encodes, and returns it
         *
         * @return string
         */
        public function getRedirectURL() {

            // If the redirect URL has been set then return it.
            if (property_exists($this, 'redirectURL') && $this->redirectURL) {
                return $this->redirectURL;
            }

            // Other-wise return the URL of the current page

            /**
             * Thank you
             * http://stackoverflow.com/questions/189113/how-do-i-get-current-page-full-url-in-php-on-a-windows-iis-server
             */
            $base_page_url = (@$_SERVER["HTTPS"] == "on") ? "https://" : "http://";
            if ($_SERVER["SERVER_PORT"] != "80" && $_SERVER["SERVER_PORT"] != "443") {
                $base_page_url .= $_SERVER["SERVER_NAME"] . ":" . $_SERVER["SERVER_PORT"];
            } else {
                $base_page_url .= $_SERVER["SERVER_NAME"];
            }

            $tmp           = explode("?", $_SERVER['REQUEST_URI']);
            $base_page_url .= $tmp[0];

            return $base_page_url;
        }

        /**
         * @param     $jwt     string encoded JWT
         * @param int $section the section we would like to decode
         *
         * @return object
         */
        private function decodeJWT($jwt, $section = 0) {

            $parts = explode(".", $jwt);
            return json_decode(base64url_decode($parts[$section]));
        }

        /**
         * @return bool
         */
        public function canVerifySignatures() {
            return true;
        }

        /**
         * @param $jwt string encoded JWT
         *
         * @throws OpenIDConnectClientException
         * @return bool
         */
        private function verifyJWTsignature($jwt) {
            $parts     = explode(".", $jwt);
            $signature = base64url_decode(array_pop($parts));
            $header    = json_decode(base64url_decode($parts[0]));
            $payload   = implode(".", $parts);
            $jwks      = json_decode($this->fetchURL($this->getProviderConfigValue('jwks_uri')));
            if ($jwks === null) {
                throw new OpenIDConnectClientException('Error decoding JSON from jwks_uri');
            }

            $verified = false;
            switch ($header->alg) {
                case 'RS256':
                case 'RS384':
                case 'RS512':
                    $hashtype = 'sha' . substr($header->alg, 2);
                    $verified = $this->verifyRSAJWTsignature($hashtype,
                        $this->get_key_for_header($jwks->keys, $header),
                        $payload, $signature);
                    break;
                default:
                    throw new OpenIDConnectClientException('No support for signature type: ' . $header->alg);
            }
            return $verified;
        }

        /**
         * @param string $hashtype
         * @param object $key
         *
         * @param        $payload
         * @param        $signature
         *
         * @return bool
         * @throws OpenIDConnectClientException
         */
        private function verifyRSAJWTsignature($hashtype, $key, $payload, $signature) {
            if (!class_exists('\phpseclib\Crypt\RSA') && !class_exists('Crypt_RSA')) {
                throw new OpenIDConnectClientException('Crypt_RSA support unavailable.');
            }
            if (!(property_exists($key, 'n') and property_exists($key, 'e'))) {
                throw new OpenIDConnectClientException('Malformed key object');
            }
            /* We already have base64url-encoded data, so re-encode it as
               regular base64 and use the XML key format for simplicity.
            */
            $public_key_xml = "<RSAKeyValue>\r\n" .
                "  <Modulus>" . b64url2b64($key->n) . "</Modulus>\r\n" .
                "  <Exponent>" . b64url2b64($key->e) . "</Exponent>\r\n" .
                "</RSAKeyValue>";
            if (class_exists('Crypt_RSA')) {
                $rsa = new Crypt_RSA();
                $rsa->setHash($hashtype);
                $rsa->loadKey($public_key_xml, Crypt_RSA::PUBLIC_FORMAT_XML);
                $rsa->signatureMode = Crypt_RSA::SIGNATURE_PKCS1;
            } else {
                $rsa = new \phpseclib\Crypt\RSA();
                $rsa->setHash($hashtype);
                $rsa->loadKey($public_key_xml, \phpseclib\Crypt\RSA::PUBLIC_FORMAT_XML);
                $rsa->signatureMode = \phpseclib\Crypt\RSA::SIGNATURE_PKCS1;
            }
            return $rsa->verify($payload, $signature);
        }

        /**
         * @param array $keys
         * @param array $header
         *
         * @throws OpenIDConnectClientException
         * @return object
         */
        private function get_key_for_header($keys, $header) {
            foreach ($keys as $key) {
                if ((!(isset($key->alg) && isset($header->kid)) && $key->kty == 'RSA') || ($key->alg == $header->alg && $key->kid == $header->kid)) {
                    return $key;
                }
            }
            if (isset($header->kid)) {
                throw new OpenIDConnectClientException('Unable to find a key for (algorithm, kid):' . $header->alg . ', ' . $header->kid . ')');
            } else {
                throw new OpenIDConnectClientException('Unable to find a key for RSA');
            }
        }

        /**
         * @param object $claims
         *
         * @return bool
         * @throws OpenIDConnectClientException
         * @throws OpenIDConnectClientException
         */
        private function verifyJWTclaims($claims) {

            return (($claims->iss == $this->getProviderURL())
                && (($claims->aud == $this->clientID) || (in_array($this->clientID, $claims->aud)))
                && ($claims->nonce == \Illuminate\Support\Facades\Session::get('openid_connect_nonce')));

        }

        /**
         * Start Here
         *
         * @return void
         * @throws OpenIDConnectClientException
         * @throws OpenIDConnectClientException
         */
        private function requestAuthorization() {

            $auth_endpoint = $this->getProviderConfigValue("authorization_endpoint");
            $response_type = "code";

            // Generate and store a nonce in the session
            // The nonce is an arbitrary value
            $nonce = $this->generateRandString();
            \Illuminate\Support\Facades\Session::put('openid_connect_nonce', $nonce);

            // State essentially acts as a session key for OIDC
            $state = $this->generateRandString();
            \Illuminate\Support\Facades\Session::put('openid_connect_state', $state);
            \Illuminate\Support\Facades\Session::save();

            $auth_params = array_merge($this->authParams, [
                'response_type' => $response_type,
                'redirect_uri'  => $this->getRedirectURL(),
                'client_id'     => $this->clientID,
                'nonce'         => $nonce,
                'state'         => $state,
                'scope'         => 'openid'
            ]);

            // If the client has been registered with additional scopes
            if (sizeof($this->scopes) > 0) {
                $auth_params = array_merge($auth_params, ['scope' => implode(' ', $this->scopes)]);
            }

            $auth_endpoint .= '?' . http_build_query($auth_params, null, '&');

            $this->redirect($auth_endpoint);

        }

        /**
         * Used for arbitrary value generation for nonces and state
         *
         * @return string
         */
        protected function generateRandString() {
            return md5(uniqid(rand(), true));
        }

        /**
         * @param $url
         */
        public function redirect($url) {
            header('Location: ' . $url);
            exit;
        }

        /**
         * @param $scope - example: openid, given_name, etc...
         */
        public function addScope($scope) {
            $this->scopes = array_merge($this->scopes, (array)$scope);
        }

        /**
         * @param $param - example: prompt=login
         */
        public function addAuthParam($param) {
            $this->authParams = array_merge($this->authParams, (array)$param);
        }

        /**
         * @param $url Sets redirect URL for auth flow
         */
        public function setRedirectURL($url) {
            if (filter_var($url, FILTER_VALIDATE_URL) !== false) {
                $this->redirectURL = $url;
            }
        }

        /**
         *
         * @param $attribute
         *
         * Attribute        Type    Description
         * user_id            string    REQUIRED Identifier for the End-User at the Issuer.
         * name            string    End-User's full name in displayable form including all name parts, ordered according to End-User's locale and
         * preferences. given_name        string    Given name or first name of the End-User. family_name        string    Surname or last name of
         * the End-User. middle_name        string    Middle name of the End-User. nickname        string    Casual name of the End-User that may or
         * may not be the same as the given_name. For instance, a nickname value of Mike might be returned alongside a given_name value of Michael.
         * profile            string    URL of End-User's profile page. picture            string    URL of the End-User's profile picture. website
         *          string    URL of End-User's web page or blog. email            string    The End-User's preferred e-mail address. verified
         *          boolean    True if the End-User's e-mail address has been verified; otherwise false. gender            string    The End-User's
         *          gender: Values defined by this specification are female and male. Other values MAY be used when neither of the defined values are
         *          applicable. birthday        string    The End-User's birthday, represented as a date string in MM/DD/YYYY format. The year MAY be
         *          0000, indicating that it is omitted. zoneinfo        string    String from zoneinfo [zoneinfo] time zone database. For example,
         *          Europe/Paris or America/Los_Angeles. locale            string    The End-User's locale, represented as a BCP47 [RFC5646] language
         *          tag. This is typically an ISO 639-1 Alpha-2 [ISO639‑1] language code in lowercase and an ISO 3166-1 Alpha-2 [ISO3166‑1] country
         *          code in uppercase, separated by a dash. For example, en-US or fr-CA. As a compatibility note, some implementations have used an
         *          underscore as the separator rather than a dash, for example, en_US; Implementations MAY choose to accept this locale syntax as
         *          well. phone_number    string    The End-User's preferred telephone number. E.164 [E.164] is RECOMMENDED as the format of this
         *          Claim. For example, +1 (425) 555-1212 or +56 (2) 687 2400. address            JSON object    The End-User's preferred address.
         *          The value of the address member is a JSON [RFC4627] structure containing some or all of the members defined in Section 2.4.2.1.
         *          updated_time    string    Time the End-User's information was last updated, represented as a RFC 3339 [RFC3339] datetime. For
         *          example, 2011-01-03T23:58:42+0000.
         *
         * @return mixed
         * @throws OpenIDConnectClientException
         */
        public function requestUserInfo($attribute = null) {

            if ($attribute !== null) {
                // Check to see if the attribute is already in memory
                if (array_key_exists($attribute, $this->userInfo)) {
                    return $this->userInfo->$attribute;
                }
            } else {
                if (!empty($this->userInfo)) return $this->userInfo;
            }

            $user_info_endpoint = $this->getProviderConfigValue("userinfo_endpoint");
            $schema             = 'openid';

            $user_info_endpoint .= "?schema=" . $schema;
            //. "&access_token=" . $this->accessToken;

            $headers = ["Authorization: Bearer {$this->accessToken}"];

            $user_json = json_decode($this->fetchURL($user_info_endpoint, null, $headers));

            $this->userInfo = $user_json;
            if ($attribute === null) return $user_json;

            if (array_key_exists($attribute, $this->userInfo)) {
                return $this->userInfo->$attribute;
            }

            return null;

        }

        /**
         * @param $httpProxy
         */
        public function setHttpProxy($httpProxy) {
            $this->httpProxy = $httpProxy;
        }

        /**
         * @param $certPath
         */
        public function setCertPath($certPath) {
            $this->certPath = $certPath;
        }

        /**
         *
         * Use this to alter a provider's endpoints and other attributes
         *
         * @param $array
         *        simple key => value
         */
        public function providerConfigParam($array) {
            $this->providerConfig = array_merge($this->providerConfig, $array);
        }

        /**
         * Dynamic registration
         *
         * @throws OpenIDConnectClientException
         */
        public function register() {

            $registration_endpoint = $this->getProviderConfigValue('registration_endpoint');

            $send_object = (object)[
                'redirect_uris' => [$this->getRedirectURL()],
                'client_name'   => $this->getClientName()
            ];

            $response = $this->fetchURL($registration_endpoint, json_encode($send_object));

            $json_response = json_decode($response);

            // Throw some errors if we encounter them
            if ($json_response === false) {
                throw new OpenIDConnectClientException("Error registering: JSON response received from the server was invalid.");
            } elseif (isset($json_response->{'error_description'})) {
                throw new OpenIDConnectClientException($json_response->{'error_description'});
            }

            $this->setClientID($json_response->{'client_id'});

            // The OpenID Connect Dynamic registration protocol makes the client secret optional
            // and provides a registration access token and URI endpoint if it is not present
            if (isset($json_response->{'client_secret'})) {
                $this->setClientSecret($json_response->{'client_secret'});
            } else {
                throw new OpenIDConnectClientException("Error registering:
                                                    Please contact the OpenID Connect provider and obtain a Client ID and Secret directly from them");
            }

        }

        /**
         * @return mixed
         */
        public function getClientName() {
            return $this->clientName;
        }

        /**
         * @param $clientName
         */
        public function setClientName($clientName) {
            $this->clientName = $clientName;
        }

        /**
         * @return string
         */
        public function getClientID() {
            return $this->clientID;
        }

        /**
         * @param $clientID
         */
        public function setClientID($clientID) {
            $this->clientID = $clientID;
        }

        /**
         * @return string
         */
        public function getClientSecret() {
            return $this->clientSecret;
        }

        /**
         * @param $clientSecret
         */
        public function setClientSecret($clientSecret) {
            $this->clientSecret = $clientSecret;
        }

        /**
         * @return string
         */
        public function getAccessToken() {
            return $this->accessToken;
        }

        /**
         * @return string
         */
        public function getRefreshToken() {
            return $this->refreshToken;
        }


    }

