<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class CheckPermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $permissionCode)
    {
        $user = Auth::user();

        // ตรวจสอบ Permission_Code
        if ($user && $user->Permission_Code === $permissionCode) {
            return $next($request);
        }

        abort(403, 'You do not have permission to access this page.');
    }
}
