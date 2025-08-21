<?php

namespace App\Http\Middleware;

use App\Models\Employee;
use App\Models\Enterprise;
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
        $enterprise = Enterprise::find($user->active_enterprise_id);

        if (! $enterprise) {
            return response()->json([
                'message' => 'L\'entreprise active n\'existe plus.',
                'error' => 'enterprise_not_found',
            ], 403);
        }

        if (! $enterprise->active) {
            return response()->json([
                'message' => 'L\'entreprise active est désactivée.',
                'error' => 'enterprise_inactive',
            ], 403);
        }

        // Check user access to this specific enterprise
        $hasAccess = false;

        // Check if user is owner of this enterprise
        if ($enterprise->owner_id === $user->id) {
            $hasAccess = true;
        }

        // Check if user is employee in this enterprise
        if (! $hasAccess) {
            $employeeRecord = Employee::where('user_id', $user->id)
                ->where('enterprise_id', $enterprise->id)
                ->first();

            if ($employeeRecord && $employeeRecord->active) {
                $hasAccess = true;
            }
        }

        if (! $hasAccess) {
            return response()->json([
                'message' => 'Vous n\'avez pas accès à cette entreprise.',
                'error' => 'unauthorized_enterprise_access',
            ], 403);
        }

        // Add enterprise information to the request for use in controllers
        $request->merge(['active_enterprise' => $enterprise]);

        return $next($request);
    }
}
