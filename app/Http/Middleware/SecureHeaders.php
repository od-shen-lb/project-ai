<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class SecureHeaders extends \LeadBest\Routers\Middleware\SecureHeaders
{
    public function handle(Request $request, Closure $next)
    {
        $response = parent::handle($request, $next);

        $response->headers->set('Content-Security-Policy', 'default-src \'self\'; style-src \'self\' \'unsafe-inline\'; script-src \'self\' \'unsafe-eval\'');

        return $response;
    }
}
