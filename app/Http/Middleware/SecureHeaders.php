<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class SecureHeaders extends \LeadBest\Routers\Middleware\SecureHeaders
{
    public function handle(Request $request, Closure $next)
    {
        $response = parent::handle($request, $next);

        $response->headers->set('Content-Security-Policy', 'default-src \'self\'; img-src \'self\' https://ui-avatars.com https://cdn.jsdelivr.net data:; style-src \'self\' \'unsafe-inline\' https://fonts.bunny.net/ https://cdn.jsdelivr.net; font-src \'self\' https://fonts.gstatic.com https://fonts.bunny.net; script-src \'self\' \'unsafe-eval\' \'unsafe-inline\'');

        return $response;
    }
}
