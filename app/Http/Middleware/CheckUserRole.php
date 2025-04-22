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

        $userRole = auth()->user()->role;

        if ($userRole->value !== $role) {
            abort(403, 'Forbidden');
        }

        return redirect('/');
    }
}
