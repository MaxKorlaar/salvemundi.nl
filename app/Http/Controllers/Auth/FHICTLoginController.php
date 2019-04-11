<?php

    namespace App\Http\Controllers\Auth;

    use App\Http\Controllers\Controller;
    use App\Member;
    use App\User;
    use Illuminate\Contracts\View\Factory;
    use Illuminate\Foundation\Auth\AuthenticatesUsers;
    use Illuminate\Http\RedirectResponse;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Log;
    use Illuminate\View\View;
    use OpenIDConnectClient;
    use OpenIDConnectClientException;
    use Session;
    use Throwable;

    /**
     * Class FHICTLoginController
     *
     * @package App\Http\Controllers\Auth
     */
    class FHICTLoginController extends Controller {
        use AuthenticatesUsers;

        protected $redirectTo = '/';
        private $client;

        /**
         * FHICTLoginController constructor.
         */
        public function __construct() {
            $this->redirectTo = route('member.index');
            require_once app_path() . '/Helpers/lib/OpenID-Connect-PHP/OpenIDConnectClient.php';
            $this->client = new OpenIDConnectClient(config('auth.fhict.openid_server'), config('auth.fhict.client_id'), config('auth.fhict.client_secret'));
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
         * @return Factory|View
         */
        public function getLoginView(Request $request) {
            if ($request->get('redirect') == true) {
                return redirect()->route('login.redirect');
            }
            return view('auth.login');
        }


        /**
         * @throws OpenIDConnectClientException
         */
        public function redirect() {
            $this->client->authenticate();
        }

        /**
         * @param Request $request
         *
         * @return RedirectResponse
         * @throws OpenIDConnectClientException
         * @throws Throwable
         */
        public function afterLoginAuth(Request $request) {
            try {
                $this->client->authenticate();
            } catch (OpenIDConnectClientException $e) {
                if ($e->getCode() === 403) {
                    return redirect()->route('login')->withErrors(['login' => trans('auth.access_denied')])->with('redirect', route('login.redirect'));
                }
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
            Log::debug('Gebruiker ingelogd via FHICT-login', ['member' => $data, 'ip' => $request->ip()]);

            if (!isset($data->email)) {
                return redirect()->route('login')->withErrors(['login' => trans('auth.email_missing')])->with('redirect', route('login.redirect'));
            }

            Session::put('fhict_login_data', $data);

            $user = User::where('username', '=', $data->preferred_username)->first();

            if ($user == null) {
                $pcn = substr($data->preferred_username, 1, strpos($data->preferred_username, '@') - 1);

                $member = Member::where('pcn', '=', $pcn)->first();
                if ($member == null) {
                    /*
                     * Plaatjes doen het tijdelijk niet (schuld FHICT)
                     *
                      $pictureToken = $this->client->fetchURL(config('auth.fhict.api_url') . '/permissions/picture_token', '{}', [], true);
                    $pictureToken = json_decode($pictureToken);
                    if (is_string($pictureToken)) {
                        dd($pictureToken, $data, $this->client->fetchURL($data->picture . '?access_token=' . $pictureToken, null, [], false));
                    }
                    dd($data, 0, $pictureToken);
                     */
                    return redirect()->route('signup.signup')->withErrors(['signup' => trans('auth.no_member_with_pcn_found')])->withInput([
                        'pcn'                => $pcn,
                        'first_name'         => $data->given_name,
                        'last_name'          => $data->family_name,
                        'email'              => $data->email,
                        'email_confirmation' => $data->email,
                    ]);
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
