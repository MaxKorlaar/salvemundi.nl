<?php

    namespace App\Providers;

    use Illuminate\Routing\UrlGenerator;
    use Illuminate\Support\ServiceProvider;

    /**
     * Class AppServiceProvider
     *
     * @package App\Providers
     */
    class AppServiceProvider extends ServiceProvider {
        /**
         * Bootstrap any application services.
         *
         * @param UrlGenerator $urlGenerator
         *
         * @return void
         */
        public function boot(UrlGenerator $urlGenerator) {
            if (app()->environment() == 'production') {
                $urlGenerator->forceScheme('https');
            }
        }

        /**
         * Register any application services.
         *
         * @return void
         */
        public function register() {
            //
        }
    }
