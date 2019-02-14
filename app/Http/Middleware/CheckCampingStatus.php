<?php

    namespace App\Http\Middleware;

    use App\User;
    use Closure;
    use Illuminate\Http\Request;

    /**
     * Class CheckCampingStatus
     *
     * @package App\Http\Middleware
     */
    class CheckCampingStatus {
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
            if ($user->rank === 'camping' || $user->isAdministrationMember()) {
                return $next($request);
            }
            return abort(403);
        }
    }
