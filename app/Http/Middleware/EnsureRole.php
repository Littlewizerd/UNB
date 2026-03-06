<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureRole
{
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        if (!auth()->check()) {
            abort(401, 'กรุณาเข้าสู่ระบบ');
        }

        if (empty($roles)) {
            return $next($request);
        }

        $userRole = strtolower((string) auth()->user()->role);
        $allowedRoles = array_map(fn (string $role) => strtolower($role), $roles);

        if (!in_array($userRole, $allowedRoles, true)) {
            abort(403, 'ไม่มีสิทธิ์เข้าถึงหน้านี้');
        }

        return $next($request);
    }
}
