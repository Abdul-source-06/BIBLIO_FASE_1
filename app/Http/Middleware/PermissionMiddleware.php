<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PermissionMiddleware
{
    public function handle(Request $request, Closure $next, $permission): Response
    {
        if (!auth()->check() || !auth()->user()->hasPermission($permission)) {
            abort(403, 'No tienes el permiso necesario.');
        }

        return $next($request);
    }
}
