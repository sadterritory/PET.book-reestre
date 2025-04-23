<?php

namespace App\Http\Middleware;

use App\Enums\UserRole;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckUserRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string $role): Response
    {

        if (!auth()->check()) {
            abort(401, 'Unauthenticated');
        }

        $allowedRoles = explode(',', $role);
        $userRole = auth()->user()->role;
        \Log::debug('Role check debug', [
            'user_role' => $userRole->value,
            'allowed_roles' => $allowedRoles,
            'auth_user' => auth()->user()->toArray(),
            'role' => $role,
        ]);

        if ($userRole->value !== $role) {
            abort(403, 'Forbidden');
        }

        return $next($request);
    }
}
