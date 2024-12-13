<?php

use App\Exceptions\Handler;
use App\Http\Router;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(web: null, commands: null, then: new Router())
    ->withMiddleware(function (Middleware $middleware) {
        $middleware
            ->append([
                // LeadBest\Routers\Middleware\SecureHeaders::class,
                \App\Http\Middleware\SecureHeaders::class,
            ])
            ->group('basic', [
                App\Http\Middleware\ForceJson::class,
                App\Http\Middleware\EncryptCookies::class,
                LeadBest\ApiLogger\RequestLogger::class,
                Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
            ])
            ->alias([
                'forceJson'      => App\Http\Middleware\ForceJson::class,
                'db.transaction' => App\Http\Middleware\DbTransactions::class,
            ]);
    })
    ->withExceptions(new Handler())
    ->create();
