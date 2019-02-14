<?php

    namespace App\Http\Middleware;

    use App\User;
    use Closure;
    use Illuminate\Http\Request;

    /**
     * Class CheckAdminStatus
     *
     * @package App\Http\Middleware
     */
    class CheckAdminStatus {
        /**
         * Handle an incoming request.
         *
         * @param  Request $request
         * @param  Closure $next
         *
         * @return mixed
         */
        public function handle($request, Closure $next) {
            /** @var User $user */
            $user = $request->user();
            if ($user->isAdministrationMember()) {
                return $next($request);
            }
            return abort(403);
        }
    }
