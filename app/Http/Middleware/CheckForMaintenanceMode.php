<?php

    namespace App\Http\Middleware;

    use Closure;
    use Illuminate\Contracts\Foundation\Application;
    use Illuminate\Foundation\Http\Exceptions\MaintenanceModeException;
    use Illuminate\Http\Request;
    use Symfony\Component\HttpKernel\Exception\HttpException;

    /**
     * Class CheckForMaintenanceMode
     *
     * @package App\Http\Middleware
     */
    class CheckForMaintenanceMode {
        /**
         * The application implementation.
         *
         * @var Application
         */
        protected $app;

        /**
         * Create a new middleware instance.
         *
         * @param  Application $app
         *
         * @return void
         */
        public function __construct(Application $app) {
            $this->app = $app;
        }

        /**
         * Handle an incoming request.
         *
         * @param  Request $request
         * @param  Closure $next
         *
         * @return mixed
         *
         * @throws HttpException
         */
        public function handle($request, Closure $next) {
            if ($this->app->isDownForMaintenance()) {
                $data = json_decode(file_get_contents($this->app->storagePath() . '/framework/down'), true);
                throw new MaintenanceModeException($data['time'], $data['retry'], $data['message']);
            }
            return $next($request);
        }
    }
