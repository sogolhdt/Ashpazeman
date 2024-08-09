<?php

namespace App\Exceptions;


use App\Traits\Responses\FailedResponseTrait;
use App\Traits\Responses\SuccessResponseTrait;
use Hekmatinasser\Jalali\Exceptions\InvalidDatetimeException;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Response;
use Illuminate\Support\ItemNotFoundException;
use Illuminate\Validation\ValidationException;
use Symfony\Component\Routing\Exception\RouteNotFoundException;
use Throwable;
use Illuminate\Http\Client\RequestException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class Handler extends ExceptionHandler
{
    use SuccessResponseTrait;
    use FailedResponseTrait;

    /**
     * A list of exception types with their corresponding custom log levels.
     *
     * @var array<class-string<\Throwable>, \Psr\Log\LogLevel::*>
     */
    protected $levels = [
        //
    ];

    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<\Throwable>>
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    public function render($request, Throwable $exception)
    {

        // if ($exception instanceof InvalidDatetimeException) {
        //     return $this->failedResponse($exception->getMessage());
        // }
        if ($exception instanceof ItemNotFoundException) {
            return $this->failedResponse($exception->getMessage());
        }
        if ($request->wantsJson()) {
            if ($exception instanceof CustomException) {
                return $this->failedResponse($exception->getMessage(), $exception->getStatusCode(), $exception->getErrors(), $exception->getErrors());
            } elseif ($exception instanceof ValidationException) {
                return $this->failedResponse($exception->getMessage(), $exception->status, $exception->errors());
            } elseif ($exception instanceof QueryException) {
                return $this->failedResponse($exception->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
            } elseif ($exception instanceof ModelNotFoundException) {
                return $this->failedResponse($exception->getMessage(), Response::HTTP_NOT_FOUND);
            } elseif ($exception instanceof RouteNotFoundException) {
                return $this->failedResponse($exception->getMessage(), Response::HTTP_NOT_FOUND);
            } elseif ($exception instanceof AuthenticationException) {
                return $this->failedResponse($exception->getMessage(), Response::HTTP_UNAUTHORIZED);
            } elseif ($exception instanceof AuthorizationException) {
                return $this->failedResponse($exception->getMessage(), Response::HTTP_UNAUTHORIZED);
            } elseif ($exception instanceof RequestException) {
                return $this->failedResponse($exception->getMessage(), Response::HTTP_BAD_REQUEST);
            }
            return $this->failedResponse($exception->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
        return parent::render($request, $exception);
    }

    public function report(Throwable $exception)
    {
        if (app()->bound('sentry') && $this->shouldReport($exception)) {
            app('sentry')->captureException($exception);
        }
        parent::report($exception);
    }
    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {

        //        $this->reportable(function (Throwable $e) {
        //            if (app()->bound('sentry')) {
        //                app('sentry')->captureException($e);
        //            }
        //        });



    }
}
