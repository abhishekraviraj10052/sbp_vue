<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class checkUserPermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {

 
        if (auth()->check() && auth()->user()->role == 'user') {
            
            $session_permission_version = $request->session()->get('permission_version');
            if (
                $session_permission_version != auth()->user()->permission_version
            ) {
                return response()->json([
                    'refresh_permissions' => true,
                    'user' => auth()->user(),
                    'session_permission_version' => $session_permission_version
                ],403);
            }
        }

        return $next($request);
    }
}
