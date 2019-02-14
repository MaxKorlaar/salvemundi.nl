<?php

    namespace App\Exceptions;

    use Exception;
    use Illuminate\Auth\AuthenticationException;
    use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
    use Illuminate\Http\Exceptions\PostTooLargeException;
    use Illuminate\Http\Request;
    use Illuminate\Http\Response;
    use Illuminate\Session\TokenMismatchException;
    use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;

    /**
     * Class Handler
     *
     * @package App\Exceptions
     */
    class Handler extends ExceptionHandler {
        /**
         * A list of the exception types that are not reported.
         *
         * @var array
         */
        protected $dontReport = [
            //
        ];

        /**
         * A list of the inputs that are never flashed for validation exceptions.
         *
         * @var array
         */
        protected $dontFlash = [
            'password',
            'password_confirmation',
        ];

        /**
         * Report or log an exception.
         *
         * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
         *
         * @param  Exception $exception
         *
         * @return void
         * @throws Exception
         */
        public function report(Exception $exception) {
            parent::report($exception);
        }

        /**
         * Render an exception into an HTTP response.
         *
         * @param  Request   $request
         * @param  Exception $exception
         *
         * @return \Symfony\Component\HttpFoundation\Response
         */
        public function render($request, Exception $exception) {

            if (!config('app.debug')) {
                if ($exception instanceof TokenMismatchException) {
                    return response(view('errors.400', ['error' => trans('error.token_mismatch')]), 400);
                }

                if ($exception instanceof MethodNotAllowedHttpException) {
                    return response(view('errors.400', ['error' => trans('error.method_not_allowed')]), 400);
                }

                if ($exception instanceof PostTooLargeException) {
                    return response(view('errors.400', ['error' => trans('error.post_size_too_large')]), 400);
                }
            }

            return parent::render($request, $exception);
        }

        /**
         * Convert an authentication exception into a response.
         *
         * @param  Request $request
         * @param AuthenticationException   $exception
         *
         * @return Response
         */
        protected function unauthenticated($request, AuthenticationException $exception) {
            return $request->expectsJson()
                ? response()->json(['message' => $exception->getMessage()], 401)
                : redirect()->guest(route('login', ['redirect' => true]));
        }

    }
