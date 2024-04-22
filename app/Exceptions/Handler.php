<?php

namespace App\Exceptions;

use App\Traits\ApiHttpResponse;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Validation\ValidationException;
use Throwable;

class Handler extends ExceptionHandler
{
    use ApiHttpResponse;

    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
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
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            //
        });

        $this->renderable(function (Throwable $e) {
            if ($e instanceof ValidationException) {
                return $this->respondValidationErrors($e);
            }

            if ($e instanceof AuthenticationException) {
                return $this->respondError('Please login to continue.');
            }

            return $this->respondError($e->getMessage(), 500, $e);
        });
    }
}
