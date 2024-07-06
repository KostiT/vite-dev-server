<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IpRestriction
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if ($this->isIpAllowed($request)) {
            return $next($request);
        }

        abort(code: 401, message: "Ip address not authorized");
    }

    protected function isIpAllowed(Request $request): bool
    {
        // only run on /restricted
        // can be done from routes definition.
        if (!$request->is("restricted*")) {
            return true;
        }

        // user needs to be signed in.
        if (!$request->user()) {
            return false;
        }

        // check if ip address exists in the column.
        return in_array(
            $request->ip(),
            $request->user()->allowed_ip ?? [],
            true
        );
    }
}
