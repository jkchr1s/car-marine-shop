<?php

namespace App\Exceptions;

use App\Http\Middleware\RequestId;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Request;
use Throwable;

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
     * Get the default context variables for logging.
     *
     * @return array
     */
    protected function context()
    {
        $context = parent::context();

        // are we in the request lifecycle?
        if (! app()->runningInConsole() && ! app()->runningUnitTests()) {
            // we are, fetch the request from the service container
            $request = app(Request::class);

            if ($request && $request->hasHeader(RequestId::REQUEST_ID_HEADER)) {
                $reqId = $request->headers->get(RequestId::REQUEST_ID_HEADER);
                $context['reqId'] = $reqId;
            }
        }

        return $context;
    }

    /**
     * Report or log an exception.
     *
     * @param  \Throwable  $exception
     * @return void
     *
     * @throws \Throwable
     */
    public function report(Throwable $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Throwable  $exception
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @throws \Throwable
     */
    public function render($request, Throwable $exception)
    {
        return parent::render($request, $exception);
    }
}
