<?php

namespace App\Http;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;

class Router
{
    protected string $namespace = 'App\\Http\\Controllers';

    public function __invoke(): void
    {
        $this->mapMiscRoutes();
        $this->mapApiRoutes('api', 'v1', 'basic');
    }

    protected function mapApiRoutes(string $module, string $version, string $middleware): void
    {
        $namespace = implode(
            '\\',
            collect([$this->namespace, $module, $version])
                ->transform(fn (string $value) => Str::studly($value))
                ->toArray()
        );

        $domain        = sprintf('%s.%s', Str::kebab(Str::camel($module)), config('app.base_domain'));
        $routeFilePath = base_path(
            sprintf(
                'routes/%s_%s.php',
                Str::snake(Str::camel($module)),
                Str::lower($version)
            )
        );

        Route::domain($domain)
            ->prefix($version)
            ->middleware($middleware)
            ->namespace($namespace)
            ->group($routeFilePath);
    }

    protected function mapMiscRoutes(): void
    {
        Route::namespace('App\\Http\\MiscControllers')->group(base_path('routes/misc.php'));
    }
}
