<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Enterprise;
use App\Models\Member;
use Inertia\Inertia;

class EnterpriseController extends Controller
{
    public function index()
    {
        $enterprises = Enterprise::with(['sector', 'country', 'plan'])
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
            'members' => [
                'label' => 'Membres',
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

        $enterprise->load(['sector', 'owner', 'country', 'plan'])
            ->loadCount(['members']);

        $members = collect();
        if ($tab === 'members') {
            $members = $enterprise->members()
                ->with('user')
                ->get();
        }

        return Inertia::render('Enterprises/Show', [
            'enterprise' => $enterprise,
            'tabs' => $tabs,
            'currentTab' => $tab,
            'members' => $members,
        ]);
    }
}
