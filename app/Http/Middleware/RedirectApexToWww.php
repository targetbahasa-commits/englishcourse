<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RedirectApexToWww
{
    /**
     * Redirect production traffic from apex host to www host.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->getHost() === 'targetbahasa.com') {
            $uri = $request->getRequestUri();
            return redirect()->to('https://www.targetbahasa.com' . $uri, 301);
        }

        return $next($request);
    }
}
