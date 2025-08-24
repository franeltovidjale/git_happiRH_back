<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Enterprise;
use Inertia\Inertia;

class EnterpriseController extends Controller
{
    public function index()
    {
        $enterprises = Enterprise::with(['sector', 'owner', 'country'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return Inertia::render('Enterprises/Index', [
            'enterprises' => $enterprises,
        ]);
    }
}