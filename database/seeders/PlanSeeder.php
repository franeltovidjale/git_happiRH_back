<?php

namespace Database\Seeders;

use App\Models\Feature;
use App\Models\Plan;
use Illuminate\Database\Seeder;

class PlanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create features first
        $features = [
            // Accès utilisateurs
            ['name' => 'Accès à (03) Utilisateurs', 'criteria' => 'max-allowed-users', 'criteria_type' => Feature::TYPE_LIMIT, 'criteria_value' => '3', 'description' => 'Gérer efficacement jusqu\'à 3 utilisateurs'],
            ['name' => 'Gérer efficacement (20) Utilisateurs', 'criteria' => 'max-allowed-users', 'criteria_type' => Feature::TYPE_LIMIT, 'criteria_value' => '20', 'description' => 'Équipe moyenne de 20 utilisateurs'],
            ['name' => 'Utilisateurs Illimités', 'criteria' => 'max-allowed-users', 'criteria_type' => Feature::TYPE_LIMIT, 'criteria_value' => 'unlimited', 'description' => 'Croissance sans limites'],

            // Gestion employés
            ['name' => 'Gestion de (10) Employés', 'criteria' => 'max-allowed-employees', 'criteria_type' => Feature::TYPE_LIMIT, 'criteria_value' => '10', 'description' => 'Équipe de 10 employés maximum'],
            ['name' => 'Équipe de (200) Employés', 'criteria' => 'max-allowed-employees', 'criteria_type' => Feature::TYPE_LIMIT, 'criteria_value' => '200', 'description' => 'PME jusqu\'à 200 employés'],
            ['name' => 'Employés Illimités', 'criteria' => 'max-allowed-employees', 'criteria_type' => Feature::TYPE_LIMIT, 'criteria_value' => 'unlimited', 'description' => 'Grande entreprise sans limites'],

            // Tâches et projets
            ['name' => '(10) Tâches par Mois', 'criteria' => 'max-allowed-tasks', 'criteria_type' => Feature::TYPE_LIMIT, 'criteria_value' => '10', 'description' => '10 tâches mensuelles incluses'],
            ['name' => '(100) Tâches par Mois', 'criteria' => 'max-allowed-tasks', 'criteria_type' => Feature::TYPE_LIMIT, 'criteria_value' => '100', 'description' => '100 tâches mensuelles incluses'],
            ['name' => 'Tâches Illimitées', 'criteria' => 'max-allowed-tasks', 'criteria_type' => Feature::TYPE_LIMIT, 'criteria_value' => 'unlimited', 'description' => 'Productivité maximale'],

            // Fonctionnalités RH
            ['name' => 'Gestion Complète des Employés', 'criteria' => 'employee-management', 'criteria_type' => Feature::TYPE_BOOLEAN, 'criteria_value' => 'yes', 'description' => 'Fiches employés complètes et détaillées'],
            ['name' => 'Gestion des Employés', 'criteria' => 'employee-management', 'criteria_type' => Feature::TYPE_BOOLEAN, 'criteria_value' => 'no', 'description' => 'Gestion des employés non disponible'],

            ['name' => 'Gestion Avancée des Tâches', 'criteria' => 'task-management', 'criteria_type' => Feature::TYPE_BOOLEAN, 'criteria_value' => 'yes', 'description' => 'Suivi et gestion des tâches en temps réel'],
            ['name' => 'Gestion des Tâches', 'criteria' => 'task-management', 'criteria_type' => Feature::TYPE_BOOLEAN, 'criteria_value' => 'no', 'description' => 'Gestion des tâches non disponible'],

            ['name' => 'Planning Basique', 'criteria' => 'leave-planning', 'criteria_type' => Feature::TYPE_BOOLEAN, 'criteria_value' => 'basic', 'description' => 'Consultation simple des congés'],
            ['name' => 'Workflow de Validation', 'criteria' => 'leave-planning', 'criteria_type' => Feature::TYPE_BOOLEAN, 'criteria_value' => 'advanced', 'description' => 'Validation automatique des congés'],
            ['name' => 'Règles Personnalisées', 'criteria' => 'leave-planning', 'criteria_type' => Feature::TYPE_BOOLEAN, 'criteria_value' => 'custom', 'description' => 'Configuration sur mesure des congés'],

            ['name' => 'Messagerie Interne', 'criteria' => 'internal-messaging', 'criteria_type' => Feature::TYPE_BOOLEAN, 'criteria_value' => 'yes', 'description' => 'Communication d\'équipe intégrée'],
            ['name' => 'Messagerie Interne', 'criteria' => 'internal-messaging', 'criteria_type' => Feature::TYPE_BOOLEAN, 'criteria_value' => 'no', 'description' => 'Messagerie interne non disponible'],

            ['name' => 'Accès Fiches de Paie', 'criteria' => 'payroll-access', 'criteria_type' => Feature::TYPE_BOOLEAN, 'criteria_value' => 'yes', 'description' => 'Consultation des salaires en ligne'],
            ['name' => 'Accès Fiches de Paie', 'criteria' => 'payroll-access', 'criteria_type' => Feature::TYPE_BOOLEAN, 'criteria_value' => 'no', 'description' => 'Accès aux fiches de paie non disponible'],

            ['name' => 'Génération CNSS Auto', 'criteria' => 'cnss-declaration', 'criteria_type' => Feature::TYPE_BOOLEAN, 'criteria_value' => 'basic', 'description' => 'Génération automatique des déclarations'],
            ['name' => 'Télé-déclaration CNSS', 'criteria' => 'cnss-declaration', 'criteria_type' => Feature::TYPE_BOOLEAN, 'criteria_value' => 'advanced', 'description' => 'Déclaration automatique en ligne'],
            ['name' => 'Déclaration CNSS', 'criteria' => 'cnss-declaration', 'criteria_type' => Feature::TYPE_BOOLEAN, 'criteria_value' => 'no', 'description' => 'Déclaration CNSS non disponible'],

            ['name' => 'Rapports de Base', 'criteria' => 'analytics-dashboard', 'criteria_type' => Feature::TYPE_BOOLEAN, 'criteria_value' => 'basic', 'description' => 'Tableaux de bord essentiels'],
            ['name' => 'BI Avancée + Export PDF', 'criteria' => 'analytics-dashboard', 'criteria_type' => Feature::TYPE_BOOLEAN, 'criteria_value' => 'advanced', 'description' => 'KPI avancés et Business Intelligence'],
            ['name' => 'Tableau de Bord', 'criteria' => 'analytics-dashboard', 'criteria_type' => Feature::TYPE_BOOLEAN, 'criteria_value' => 'no', 'description' => 'Tableau de bord non disponible'],

            ['name' => 'Import/Export Excel', 'criteria' => 'excel-import-export', 'criteria_type' => Feature::TYPE_BOOLEAN, 'criteria_value' => 'yes', 'description' => 'Synchronisation Excel complète'],
            ['name' => 'Import/Export Excel', 'criteria' => 'excel-import-export', 'criteria_type' => Feature::TYPE_BOOLEAN, 'criteria_value' => 'no', 'description' => 'Import/Export Excel non disponible'],

            ['name' => 'Workflow RH Multi-niveaux', 'criteria' => 'hr-workflow', 'criteria_type' => Feature::TYPE_BOOLEAN, 'criteria_value' => 'yes', 'description' => 'Validation hiérarchique automatisée'],
            ['name' => 'Workflow RH', 'criteria' => 'hr-workflow', 'criteria_type' => Feature::TYPE_BOOLEAN, 'criteria_value' => 'no', 'description' => 'Workflow RH non disponible'],

            ['name' => 'Notifications Email/SMS', 'criteria' => 'email-sms-notifications', 'criteria_type' => Feature::TYPE_BOOLEAN, 'criteria_value' => 'yes', 'description' => 'Alertes automatiques multi-canaux'],
            ['name' => 'Notifications Email/SMS', 'criteria' => 'email-sms-notifications', 'criteria_type' => Feature::TYPE_BOOLEAN, 'criteria_value' => 'no', 'description' => 'Notifications non disponibles'],

            ['name' => 'Intégrations Tierces', 'criteria' => 'third-party-integrations', 'criteria_type' => Feature::TYPE_BOOLEAN, 'criteria_value' => 'yes', 'description' => 'API REST, ERP, Comptabilité'],
            ['name' => 'Intégrations Tierces', 'criteria' => 'third-party-integrations', 'criteria_type' => Feature::TYPE_BOOLEAN, 'criteria_value' => 'no', 'description' => 'Intégrations tierces non disponibles'],

            ['name' => 'Support FAQ + Email', 'criteria' => 'priority-support', 'criteria_type' => Feature::TYPE_BOOLEAN, 'criteria_value' => 'basic', 'description' => 'Support par FAQ et email'],
            ['name' => 'Support Email + Chat', 'criteria' => 'priority-support', 'criteria_type' => Feature::TYPE_BOOLEAN, 'criteria_value' => 'standard', 'description' => 'Support email et chat en horaires ouvrables'],
            ['name' => 'Support Premium 24/7', 'criteria' => 'priority-support', 'criteria_type' => Feature::TYPE_BOOLEAN, 'criteria_value' => 'premium', 'description' => 'Support 24/7 + gestionnaire dédié'],
        ];

        foreach ($features as $featureData) {
            Feature::updateOrCreate(
                ['criteria' => $featureData['criteria'], 'criteria_value' => $featureData['criteria_value'] ?? null],
                $featureData
            );
        }

        // Create plans
        $plans = [
            [
                'name' => 'Free',
                'slug' => 'free',
                'description' => 'Destiné aux petites équipes ou tests',
                'price' => 0.00,
                'currency' => 'XOF',
                'billing_cycle' => Plan::BILLING_CYCLE_MONTHLY,
                'is_active' => true,
            ],
            [
                'name' => 'Pro',
                'slug' => 'pro',
                'description' => 'Destiné aux PME (équipe moyenne)',
                'price' => 15000.00,
                'currency' => 'XOF',
                'billing_cycle' => Plan::BILLING_CYCLE_MONTHLY,
                'is_active' => true,
                'is_recommended' => true,
            ],
            [
                'name' => 'Business',
                'slug' => 'business',
                'description' => 'Destiné aux grandes entreprises / administrations',
                'price' => 50000.00,
                'currency' => 'XOF',
                'billing_cycle' => Plan::BILLING_CYCLE_MONTHLY,
                'is_active' => true,
            ],
        ];

        foreach ($plans as $planData) {
            $plan = Plan::updateOrCreate(
                ['slug' => $planData['slug']],
                $planData
            );

            // Attach features based on plan
            $this->attachFeaturesToPlan($plan);
        }
    }

    /**
     * Attach features to a specific plan
     */
    private function attachFeaturesToPlan(Plan $plan): void
    {
        $features = Feature::all()->keyBy('criteria');

        switch ($plan->slug) {
            case 'free':
                $this->attachFreeFeatures($plan, $features);
                break;
            case 'pro':
                $this->attachProFeatures($plan, $features);
                break;
            case 'business':
                $this->attachBusinessFeatures($plan, $features);
                break;
        }
    }

    /**
     * Attach features for Free plan
     */
    private function attachFreeFeatures(Plan $plan, $features): void
    {
        $freeFeatures = [
            'max-allowed-users' => ['is_enabled' => true],
            'max-allowed-employees' => ['is_enabled' => true],
            'max-allowed-tasks' => ['is_enabled' => true],
            'employee-management' => ['is_enabled' => true],
            'task-management' => ['is_enabled' => true],
            'leave-planning' => ['is_enabled' => true],
            'internal-messaging' => ['is_enabled' => true],
            'payroll-access' => ['is_enabled' => true],
            'cnss-declaration' => ['is_enabled' => true],
            'analytics-dashboard' => ['is_enabled' => true],
            'excel-import-export' => ['is_enabled' => true],
            'hr-workflow' => ['is_enabled' => true],
            'email-sms-notifications' => ['is_enabled' => true],
            'third-party-integrations' => ['is_enabled' => true],
            'priority-support' => ['is_enabled' => true],
        ];

        foreach ($freeFeatures as $criteria => $pivot) {
            // Get the feature with the specific criteria value for free plan
            $feature = Feature::where('criteria', $criteria)
                ->where('criteria_value', $this->getFreePlanValue($criteria))
                ->first();

            if ($feature) {
                $plan->features()->syncWithoutDetaching([
                    $feature->id => $pivot,
                ]);
            }
        }
    }

    /**
     * Attach features for Pro plan
     */
    private function attachProFeatures(Plan $plan, $features): void
    {
        $proFeatures = [
            'max-allowed-users' => ['is_enabled' => true],
            'max-allowed-employees' => ['is_enabled' => true],
            'max-allowed-tasks' => ['is_enabled' => true],
            'employee-management' => ['is_enabled' => true],
            'task-management' => ['is_enabled' => true],
            'leave-planning' => ['is_enabled' => true],
            'internal-messaging' => ['is_enabled' => true],
            'payroll-access' => ['is_enabled' => true],
            'cnss-declaration' => ['is_enabled' => true],
            'analytics-dashboard' => ['is_enabled' => true],
            'excel-import-export' => ['is_enabled' => true],
            'hr-workflow' => ['is_enabled' => true],
            'email-sms-notifications' => ['is_enabled' => true],
            'third-party-integrations' => ['is_enabled' => true],
            'priority-support' => ['is_enabled' => true],
        ];

        foreach ($proFeatures as $criteria => $pivot) {
            // Get the feature with the specific criteria value for pro plan
            $feature = Feature::where('criteria', $criteria)
                ->where('criteria_value', $this->getProPlanValue($criteria))
                ->first();

            if ($feature) {
                $plan->features()->syncWithoutDetaching([
                    $feature->id => $pivot,
                ]);
            }
        }
    }

    /**
     * Attach features for Business plan
     */
    private function attachBusinessFeatures(Plan $plan, $features): void
    {
        $businessFeatures = [
            'max-allowed-users' => ['is_enabled' => true],
            'max-allowed-employees' => ['is_enabled' => true],
            'max-allowed-tasks' => ['is_enabled' => true],
            'employee-management' => ['is_enabled' => true],
            'task-management' => ['is_enabled' => true],
            'leave-planning' => ['is_enabled' => true],
            'internal-messaging' => ['is_enabled' => true],
            'payroll-access' => ['is_enabled' => true],
            'cnss-declaration' => ['is_enabled' => true],
            'analytics-dashboard' => ['is_enabled' => true],
            'excel-import-export' => ['is_enabled' => true],
            'hr-workflow' => ['is_enabled' => true],
            'email-sms-notifications' => ['is_enabled' => true],
            'third-party-integrations' => ['is_enabled' => true],
            'priority-support' => ['is_enabled' => true],
        ];

        foreach ($businessFeatures as $criteria => $pivot) {
            // Get the feature with the specific criteria value for business plan
            $feature = Feature::where('criteria', $criteria)
                ->where('criteria_value', $this->getBusinessPlanValue($criteria))
                ->first();

            if ($feature) {
                $plan->features()->syncWithoutDetaching([
                    $feature->id => $pivot,
                ]);
            }
        }
    }

    /**
     * Get the criteria value for Free plan
     */
    private function getFreePlanValue(string $criteria): string
    {
        return match ($criteria) {
            'max-allowed-users' => '3',
            'max-allowed-employees' => '10',
            'max-allowed-tasks' => '10',
            'employee-management' => 'yes',
            'task-management' => 'yes',
            'leave-planning' => 'basic',
            'internal-messaging' => 'no',
            'payroll-access' => 'no',
            'cnss-declaration' => 'no',
            'analytics-dashboard' => 'no',
            'excel-import-export' => 'no',
            'hr-workflow' => 'no',
            'email-sms-notifications' => 'no',
            'third-party-integrations' => 'no',
            'priority-support' => 'basic',
            default => 'unlimited',
        };
    }

    /**
     * Get the criteria value for Pro plan
     */
    private function getProPlanValue(string $criteria): string
    {
        return match ($criteria) {
            'max-allowed-users' => '20',
            'max-allowed-employees' => '200',
            'max-allowed-tasks' => '100',
            'employee-management' => 'yes',
            'task-management' => 'yes',
            'leave-planning' => 'advanced',
            'internal-messaging' => 'yes',
            'payroll-access' => 'yes',
            'cnss-declaration' => 'basic',
            'analytics-dashboard' => 'basic',
            'excel-import-export' => 'yes',
            'hr-workflow' => 'no',
            'email-sms-notifications' => 'no',
            'third-party-integrations' => 'no',
            'priority-support' => 'standard',
            default => 'unlimited',
        };
    }

    /**
     * Get the criteria value for Business plan
     */
    private function getBusinessPlanValue(string $criteria): string
    {
        return match ($criteria) {
            'max-allowed-users' => 'unlimited',
            'max-allowed-employees' => 'unlimited',
            'max-allowed-tasks' => 'unlimited',
            'employee-management' => 'yes',
            'task-management' => 'yes',
            'leave-planning' => 'custom',
            'internal-messaging' => 'yes',
            'payroll-access' => 'yes',
            'cnss-declaration' => 'advanced',
            'analytics-dashboard' => 'advanced',
            'excel-import-export' => 'yes',
            'hr-workflow' => 'yes',
            'email-sms-notifications' => 'yes',
            'third-party-integrations' => 'yes',
            'priority-support' => 'premium',
            default => 'unlimited',
        };
    }
}