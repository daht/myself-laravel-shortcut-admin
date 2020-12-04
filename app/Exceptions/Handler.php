<?php

namespace App\Exceptions;


use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Validation\ValidationException;

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

    /**
     *  将异常转换为 HTTP 响应。
     * @param \Illuminate\Http\Request $request
     * @param Exception $exception
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response|\Symfony\Component\HttpFoundation\Response
     * @throws \Throwable
     */
    public function render($request, $exception)
    {

        if ($exception instanceof ValidationException) {
            $resource_data = resource_data();
            $resource_data['meta'] = [
                'status_code' => $exception->status,
                'debug' => $exception->getTrace(),
                'message' => $exception->getMessage(),
                'errors' => $exception->errors(),
            ];
            return response($resource_data, $exception->status);
        }
        return parent::render($request, $exception);
    }

}
