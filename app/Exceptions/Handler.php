<?php

namespace App\Exceptions;

use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Http\Exceptions\ThrottleRequestsException;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\App;
use Illuminate\Validation\ValidationException;
use PHPOpenSourceSaver\JWTAuth\Exceptions\TokenBlacklistedException;
use PHPOpenSourceSaver\JWTAuth\Exceptions\TokenInvalidException;
use Sentry\Laravel\Integration;
use Symfony\Component\Console\Exception\CommandNotFoundException;
use Symfony\Component\Console\Exception\InvalidArgumentException as ConsoleInvalidArgumentException;
use Symfony\Component\Console\Exception\InvalidOptionException as ConsoleInvalidOptionException;
use Symfony\Component\Console\Exception\RuntimeException as ConsoleRuntimeException;
use Symfony\Component\HttpKernel\Exception\HttpException as SymfonyHttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

class Handler
{
    protected array $dontReport = [
        AppException::class,
        NotFoundHttpException::class,
        AuthenticationException::class,
        TokenInvalidException::class,
        TokenBlacklistedException::class,
        MethodNotAllowedHttpException::class,
        ValidationException::class,
        CommandNotFoundException::class,
        ConsoleInvalidArgumentException::class,
        ConsoleInvalidOptionException::class,
        ConsoleRuntimeException::class,
    ];

    public function __invoke(Exceptions $exceptions): void
    {
        Integration::handles(
            $exceptions
                ->dontReportDuplicates()
                ->dontReport($this->dontReport)
                ->renderable([$this, 'renderable'])
        );
    }

    public function renderable(Throwable $exception): ?JsonResponse
    {
        if (App::environment() === 'local') {
            return null;
        }

        $message = null;
        $errors  = [];
        $headers = [];

        switch (get_class($exception)) {
            case AuthenticationException::class:
            case TokenInvalidException::class:
            case TokenBlacklistedException::class:
                $statusCode = 401;
                $message    = 'unAuthenticated';
                $errors[]   = ['message' => $message];

                break;
            case NotFoundHttpException::class:
                $statusCode = 404;
                $message    = 'notFound';
                $errors[]   = ['message' => $message];

                break;
            case MethodNotAllowedHttpException::class:
                $statusCode = 405;
                $message    = 'methodNotAllowed';
                $errors[]   = ['message' => $message];

                break;
            case ValidationException::class:
                /** @var ValidationException $exception */
                $statusCode = 422;

                foreach ($exception->errors() as $field => $messages) {
                    foreach ($messages as $message) {
                        $errors[] = [
                            'field'   => $field,
                            'message' => $message,
                        ];
                    }
                }

                break;
            case ThrottleRequestsException::class:
                $statusCode = 429;
                $message    = 'tooManyAttempts';
                $errors[]   = ['message' => $message];

                break;
            default:
                $statusCode = 500;
                $message    = 'unknownError';
                $errors[]   = ['message' => $message];

                break;
        }

        if ($exception instanceof SymfonyHttpException && App::isDownForMaintenance()) {
            $statusCode = 503;
            $message    = 'InMaintenance';
            $errors     = [['message' => $message]];
            $headers    = ['Retry-After' => 60];
        }

        return response()->json(['errors' => $errors], $statusCode, $headers);
    }
}
