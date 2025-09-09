<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SetActiveEnterpriseMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if (! $user) {
            return response()->json([
                'message' => 'Utilisateur non authentifié',
            ], 401);
        }

        // Check if user has an active enterprise
        if (! $user->active_enterprise_id) {
            return response()->json([
                'message' => 'Aucune entreprise active sélectionnée. Veuillez sélectionner une entreprise.',
                'error' => 'no_active_enterprise',
            ], 403);
        }

        // Verify the enterprise exists and is active
        $enterprise = $user->activeEnterprise;

        if (! $enterprise) {
            return response()->json([
                'message' => 'L\'entreprise active n\'existe plus.',
                'error' => 'enterprise_not_found',
            ], 403);
        }

        // Add enterprise information to the request for use in controllers
        $request->merge(['active_enterprise_id' => $enterprise->id]);

        $request->attributes->add(['active_enterprise' => $enterprise]);

        return $next($request);
    }
}
