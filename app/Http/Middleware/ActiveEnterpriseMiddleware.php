<?php

namespace App\Http\Middleware;

use App\Models\Employee;
use App\Models\Enterprise;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ActiveEnterpriseMiddleware
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

        // Check user access based on their type
        if ($user->type === 'employer') {
            // For employers, check if they own this enterprise
            if ($enterprise->owner_id !== $user->id) {
                return response()->json([
                    'message' => 'Vous n\'avez pas accès à cette entreprise.',
                    'error' => 'unauthorized_enterprise_access',
                ], 403);
            }
        } elseif ($user->type === 'employee') {
            // For employees, check if they are associated with this enterprise
            $employeeRecord = Employee::where('user_id', $user->id)
                ->where('enterprise_id', $enterprise->id)
                ->first();

            if (! $employeeRecord) {
                return response()->json([
                    'message' => 'Vous n\'êtes pas associé à cette entreprise.',
                    'error' => 'unauthorized_enterprise_access',
                ], 403);
            }

            if (! $employeeRecord->active) {
                return response()->json([
                    'message' => 'Votre compte employé est désactivé dans cette entreprise.',
                    'error' => 'employee_inactive',
                ], 403);
            }
        } else {
            // For other user types (admin, normal), allow access
            // You can add specific logic here if needed
        }

        // Add enterprise information to the request for use in controllers
        $request->merge(['active_enterprise' => $enterprise]);

        return $next($request);
    }
}
