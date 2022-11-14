<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\QueryException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;


class Handler extends ExceptionHandler
{
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
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {
        $this->reportable(function (Throwable $e) {
            //
        });

        $this->renderable(function(\Exception $e, $request) {
            return $this->handleException($request, $e);
        });


    }

    public function handleException($request, \Exception $exception)
    {
        // if($exception instanceof NotFoundHttpException) {
        //     return response(['message'=>'The specified URL cannot be  found.'], 404);
        // }

        if($exception instanceof MethodNotAllowedHttpException) {
            return response(['message'=>'The bad request cannot be  found.'], 404);
        }

        if($exception instanceof QueryException) {
            return response(['message'=>$exception], 404);
        }
    }
    /**
     * Convert an authentication exception into an unauthenticated response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Illuminate\Auth\AuthenticationException  $exception
     * @return \Illuminate\Http\Response
     */
    protected function unauthenticated($request, AuthenticationException $exception)
    {
        if ($request->expectsJson() || $request->is('api*')) {
            return response()->json(['error' => __('auth.unauthenticated')], 401);
        }

        return redirect()->guest(route('login'));
    }
}
