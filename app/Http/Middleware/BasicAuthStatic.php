<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Symfony\Component\HttpFoundation\Response;

class BasicAuthStatic
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // https://gist.github.com/FlorianWeigang/2fe04b2f3df85f7491cf
        if ($request->getUser() === Config::get('auth.sso.username') && $request->getPassword() === Config::get('auth.sso.password')) {
            return $next($request);
        }

        return Response()->json([
            'error' => [
               'message' => 'Invalid credentials.'
            ],
        ], 401);

        // If you need this for the web request
        //return new Response('Invalid credentials.', 401, ['WWW-Authenticate' => 'Basic']);
    }
}
