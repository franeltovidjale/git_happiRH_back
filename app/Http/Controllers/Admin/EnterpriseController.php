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

    public function show(Enterprise $enterprise)
    {
        $tabs = [
            'dashboard' => [
                'label' => 'Détails de l\'entreprise',
                'icon' => 'LayoutDashboard',
            ],
            'employees' => [
                'label' => 'Employés',
                'icon' => 'Users',
            ],
            'documents' => [
                'label' => 'Documents',
                'icon' => 'FileText',
            ],
            'analytics' => [
                'label' => 'Analytics',
                'icon' => 'BarChart3',
            ],
            'actions' => [
                'label' => 'Actions',
                'icon' => 'Settings',
            ],
        ];

        $tab = request('tab', 'dashboard');

        if (!array_key_exists($tab, $tabs)) {
            $tab = 'dashboard';
        }

        $employees = collect();
        if ($tab === 'employees') {
            $employees = $enterprise->members()->with('user')->where('type', 'employee')->get();
        }

        return Inertia::render('Enterprises/Show', [
            'enterprise' => $enterprise->load(['sector', 'owner', 'country']),
            'tabs' => $tabs,
            'currentTab' => $tab,
            'employees' => $employees,
        ]);
    }
}