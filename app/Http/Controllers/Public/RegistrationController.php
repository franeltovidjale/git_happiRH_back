<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Enterprise;

class RegistrationController extends Controller
{
    public function registerSuccess()
    {
        $enterpriseId = session()->get('enterprise_id');
        $enterprise = Enterprise::find($enterpriseId);

        if (! $enterprise) {
            return redirect()->route('welcome');
        }

        $data = [
            'enterprise' => $enterprise,
            'message' => 'Votre compte a été créé avec succès. Vous pouvez désormais accéder à votre espace client.',
        ];

        session()->forget('enterprise_id');

        return view('public.register-feedback', $data);
    }
}
