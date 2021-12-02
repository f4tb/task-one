<?php

namespace App\Exceptions;

use App\Helpers\ApiHelper;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var string[]
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var string[]
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

        });
    }

    public function render($request, Throwable $e)
    {
        if ($e instanceof ModelNotFoundException) {
            return response()->json(ApiHelper::std_response_format([
                'success' => false,
                'error' => array('message' => 'Not Found'),
                'errors' => [],
                'data' => []
            ]), 404);
        }
        return parent::render($request, $e);
    }

    protected function unauthenticated($request, AuthenticationException $exception)
    {
        if ($request->wantsJson()){
            return response()->json(ApiHelper::std_response_format([
                'success' => false,
                'error' => array('message' => 'Unauthenticated'),
                'errors' => [],
                'data' => []
            ]), 401);
        }
        return parent::unauthenticated($request, $exception);
    }
}
