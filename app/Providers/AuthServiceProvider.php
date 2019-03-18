<?php

    namespace App\Providers;

    use App\User;
    use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
    use Illuminate\Support\Facades\Gate;

    /**
     * Class AuthServiceProvider
     *
     * @package App\Providers
     */
    class AuthServiceProvider extends ServiceProvider {
        /**
         * The policy mappings for the application.
         *
         * @var array
         */
        protected $policies = [
            'App\Model' => 'App\Policies\ModelPolicy',
        ];

        /**
         * Register any authentication / authorization services.
         *
         * @return void
         */
        public function boot() {
            $this->registerPolicies();


            Gate::before(function ($user, $ability) {
                /** @var User $user */
                return $user->isAdministrationMember() ? true : null;
            });
        }
    }
