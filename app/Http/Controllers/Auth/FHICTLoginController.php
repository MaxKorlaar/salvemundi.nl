<?php

    namespace App\Http\Controllers\Auth;

    use App\Http\Controllers\Controller;
    use App\Member;
    use App\User;
    use Illuminate\Foundation\Auth\AuthenticatesUsers;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Log;

    /**
     * Class FHICTLoginController
     *
     * @package App\Http\Controllers\Auth
     */
    class FHICTLoginController extends Controller {
        use AuthenticatesUsers;

        protected $redirectTo = '/';
        private $client;

        function __construct() {
            $this->redirectTo = route('member.about_me');
            require_once app_path() . '/Helpers/lib/OpenID-Connect-PHP/OpenIDConnectClient.php';
            $this->client = new \OpenIDConnectClient(config('auth.fhict.openid_server'), config('auth.fhict.client_id'), config('auth.fhict.client_secret'));
            $this->client->addScope(explode(" ", config('auth.fhict.scopes')));
            if (config('app.env') == 'local') {
                $this->client->setRedirectURL('http://localhost:3000/login/oauth');
                //                $this->client->setRedirectURL('https://salvemundi.nl/login/oauth');
            } else {
                $this->client->setRedirectURL(route('login.redirect_url'));
            }
            $this->middleware('guest')->except(['logout']);
        }

        /**
         * @param Request $request
         *
         * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
         */
        public function getLoginView(Request $request) {
            if ($request->get('redirect') == true) {
                return redirect()->route('login.redirect');
            }
            return view('auth.login');
        }


        /**
         * @throws \OpenIDConnectClientException
         */
        public function redirect() {
            $this->client->authenticate();
        }

        /**
         * @param Request $request
         *
         * @return \Illuminate\Http\RedirectResponse
         * @throws \OpenIDConnectClientException
         * @throws \Throwable
         */
        public function afterLoginAuth(Request $request) {
            try {
                $this->client->authenticate();
            } catch (\OpenIDConnectClientException $e) {
                if ($e->getMessage() !== null) {
                    $error = json_decode($e->getMessage());
                    if ($error !== null) {
                        if ($error->error == 'invalid_grant') {
                            return redirect()->route('login.redirect');
                        }
                    }

                }
                throw $e;

            }
            $data = $this->client->requestUserInfo();
            \Session::put('fhict_login_data', $data);
            Log::info('Gebruiker ingelogd via FHICT-login', ['member' => $data, 'ip' => $request->ip()]);

            $user = User::where('username', '=', $data->preferred_username)->first();

            if ($user == null) {
                $pcn = substr($data->preferred_username, 1, strpos($data->preferred_username, '@') - 1);

                $member = Member::where('pcn', '=', $pcn)->first();
                if ($member == null) {
                    return redirect()->route('login')->withErrors(['login' => trans('auth.no_member_with_pcn_found')]);
                }
                $user = User::createFromMember($member, $data);
                $this->guard()->login($user, true);

                return redirect()->intended($this->redirectPath());
            }
            $user->updateFontysData($data);
            $this->guard()->login($user, true);
            return redirect()->intended($this->redirectPath());
        }
    }
