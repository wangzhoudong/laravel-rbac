<?php

namespace Lwj\Rbac\Https\Middleware;


use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class Authenticate
{
    /**
     * Handle the incoming request.
     *
     * @param  Request  $request
     * @param  Closure  $next
     * @return Response|null
     */
    public function handle($request, $next)
    {
        return $next($request);
    }
}
