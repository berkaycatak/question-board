<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<Throwable>>
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array<int, string>
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
    }

    public function render($request, Exception $e){
        $code = $e->getCode();
        if(empty($code)){$code = 500;}
        $message = $e->getMessage();
        if (stripos($message, 'The given data was invalid') !== false) {
            $code = 422;
            $message = print_r($e->validator->failed(),true);
        }
        if ($request->expectsJson()) {
            return response()->json([
                'error' =>  $message,
                'message' => $message,
            ], $code);
        }
        return parent::render($request, $e);
    }

}
