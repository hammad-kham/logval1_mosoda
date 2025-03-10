<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;

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
        //
    }

   /* public function render($request, Exception $exception)
    {
        if (Request::isMethod('post') && $exception instanceof MethodNotAllowedHttpException) {
            return response()->json([
                'message' => 'Page Not Found',
                'status' => false
                ], 500
            );
        }
        return parent::render($request, $exception);
    }*/
}
