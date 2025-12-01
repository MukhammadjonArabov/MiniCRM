<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckPermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string $permission): Response
    {
        $user = $request->user();
        if (!$user || !$user->hasPermission($permission)) {
            abort(403, 'Sizda bu amalni bajarish ruxsati yo‘q!');
        }
        return $next($request);
    }
}



//App/Http/Middleware/ChackPermission.php 
