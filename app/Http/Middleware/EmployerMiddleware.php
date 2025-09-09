<?php

namespace App\Http\Middleware;

use App\Models\Enterprise;
use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EmployerMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (! auth()->check()) {
            return response()->json(['message' => 'Unauthorized. Employer access required.'], 403);
        }
        /**
         * @var User
         */
        $user = auth()->user();
        /**
         * @var Enterprise|null
         */
        $activeEnterprise = $user->activeEnterprise;

        if (! $activeEnterprise) {
            return response()->json(['message' => 'Unauthorized. Empty company.'], 403);
        }

        if ($activeEnterprise->gerant_id !== $user->id) {
            return response()->json(['message' => 'Unauthorized. Employer access required.'], 403);
        }

        return $next($request);
    }
}
