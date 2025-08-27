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
            // Accès utilisateurs (coût: stockage + performance)
            ['name' => 'Accès à (02) Utilisateurs', 'criteria' => 'max-allowed-users', 'criteria_type' => Feature::TYPE_LIMIT, 'criteria_value' => '2', 'description' => 'Gérer efficacement jusqu\'à 2 utilisateurs'],
            ['name' => 'Gérer efficacement (05) Utilisateurs', 'criteria' => 'max-allowed-users', 'criteria_type' => Feature::TYPE_LIMIT, 'criteria_value' => '5', 'description' => 'Équipe moyenne de 5 utilisateurs'],
            ['name' => 'Utilisateurs Illimités', 'criteria' => 'max-allowed-users', 'criteria_type' => Feature::TYPE_LIMIT, 'criteria_value' => 'unlimited', 'description' => 'Croissance sans limites'],

            // Tâches et projets (coût: stockage + traitement)
            ['name' => '(10) Tâches par Mois', 'criteria' => 'max-allowed-tasks', 'criteria_type' => Feature::TYPE_LIMIT, 'criteria_value' => '10', 'description' => '10 tâches mensuelles incluses'],
            ['name' => '(100) Tâches par Mois', 'criteria' => 'max-allowed-tasks', 'criteria_type' => Feature::TYPE_LIMIT, 'criteria_value' => '100', 'description' => '100 tâches mensuelles incluses'],
            ['name' => 'Tâches Illimitées', 'criteria' => 'max-allowed-tasks', 'criteria_type' => Feature::TYPE_LIMIT, 'criteria_value' => 'unlimited', 'description' => 'Productivité maximale'],

            // Fonctionnalités RH (coût: développement + maintenance)
            ['name' => 'Gestion Complète des Employés', 'criteria' => 'employee-management', 'criteria_type' => Feature::TYPE_BOOLEAN, 'criteria_value' => 'yes', 'description' => 'Fiches employés complètes et détaillées'],
            ['name' => 'Gestion des Employés', 'criteria' => 'employee-management', 'criteria_type' => Feature::TYPE_BOOLEAN, 'criteria_value' => 'no', 'description' => 'Gestion des employés non disponible'],

            ['name' => 'Gestion Avancée des Tâches', 'criteria' => 'task-management', 'criteria_type' => Feature::TYPE_BOOLEAN, 'criteria_value' => 'yes', 'description' => 'Suivi et gestion des tâches en temps réel'],
            ['name' => 'Gestion des Tâches', 'criteria' => 'task-management', 'criteria_type' => Feature::TYPE_BOOLEAN, 'criteria_value' => 'no', 'description' => 'Gestion des tâches non disponible'],

            ['name' => 'Planning Basique', 'criteria' => 'leave-planning', 'criteria_type' => Feature::TYPE_BOOLEAN, 'criteria_value' => 'basic', 'description' => 'Consultation simple des congés'],
            ['name' => 'Workflow de Validation', 'criteria' => 'leave-planning', 'criteria_type' => Feature::TYPE_BOOLEAN, 'criteria_value' => 'advanced', 'description' => 'Validation automatique des congés'],
            ['name' => 'Règles Personnalisées', 'criteria' => 'leave-planning', 'criteria_type' => Feature::TYPE_BOOLEAN, 'criteria_value' => 'custom', 'description' => 'Configuration sur mesure des congés'],

            // Messagerie (coût: stockage + bande passante)
            ['name' => 'Messagerie Interne', 'criteria' => 'internal-messaging', 'criteria_type' => Feature::TYPE_BOOLEAN, 'criteria_value' => 'yes', 'description' => 'Communication d\'équipe intégrée'],
            ['name' => 'Messagerie Interne', 'criteria' => 'internal-messaging', 'criteria_type' => Feature::TYPE_BOOLEAN, 'criteria_value' => 'no', 'description' => 'Messagerie interne non disponible'],

            // Fiches de paie (coût: calculs complexes + stockage)
            ['name' => 'Accès Fiches de Paie', 'criteria' => 'payroll-access', 'criteria_type' => Feature::TYPE_BOOLEAN, 'criteria_value' => 'yes', 'description' => 'Consultation des salaires en ligne'],
            ['name' => 'Accès Fiches de Paie', 'criteria' => 'payroll-access', 'criteria_type' => Feature::TYPE_BOOLEAN, 'criteria_value' => 'no', 'description' => 'Accès aux fiches de paie non disponible'],

            // CNSS (coût: intégration API + traitement)
            ['name' => 'Génération CNSS Auto', 'criteria' => 'cnss-declaration', 'criteria_type' => Feature::TYPE_BOOLEAN, 'criteria_value' => 'basic', 'description' => 'Génération automatique des déclarations'],
            ['name' => 'Télé-déclaration CNSS', 'criteria' => 'cnss-declaration', 'criteria_type' => Feature::TYPE_BOOLEAN, 'criteria_value' => 'advanced', 'description' => 'Déclaration automatique en ligne'],
            ['name' => 'Déclaration CNSS', 'criteria' => 'cnss-declaration', 'criteria_type' => Feature::TYPE_BOOLEAN, 'criteria_value' => 'no', 'description' => 'Déclaration CNSS non disponible'],

            // Analytics (coût: traitement + stockage)
            ['name' => 'Rapports de Base', 'criteria' => 'analytics-dashboard', 'criteria_type' => Feature::TYPE_BOOLEAN, 'criteria_value' => 'basic', 'description' => 'Tableaux de bord essentiels'],
            ['name' => 'BI Avancée + Export PDF', 'criteria' => 'analytics-dashboard', 'criteria_type' => Feature::TYPE_BOOLEAN, 'criteria_value' => 'advanced', 'description' => 'KPI avancés et Business Intelligence'],
            ['name' => 'Tableau de Bord', 'criteria' => 'analytics-dashboard', 'criteria_type' => Feature::TYPE_BOOLEAN, 'criteria_value' => 'no', 'description' => 'Tableau de bord non disponible'],

            // Import/Export (coût: traitement + bande passante)
            ['name' => 'Import/Export Excel', 'criteria' => 'excel-import-export', 'criteria_type' => Feature::TYPE_BOOLEAN, 'criteria_value' => 'yes', 'description' => 'Synchronisation Excel complète'],
            ['name' => 'Import/Export Excel', 'criteria' => 'excel-import-export', 'criteria_type' => Feature::TYPE_BOOLEAN, 'criteria_value' => 'no', 'description' => 'Import/Export Excel non disponible'],

            // Workflow (coût: développement complexe)
            ['name' => 'Workflow RH Multi-niveaux', 'criteria' => 'hr-workflow', 'criteria_type' => Feature::TYPE_BOOLEAN, 'criteria_value' => 'yes', 'description' => 'Validation hiérarchique automatisée'],
            ['name' => 'Workflow RH', 'criteria' => 'hr-workflow', 'criteria_type' => Feature::TYPE_BOOLEAN, 'criteria_value' => 'no', 'description' => 'Workflow RH non disponible'],

            // Notifications (coût: services externes)
            ['name' => 'Notifications Email/SMS', 'criteria' => 'email-sms-notifications', 'criteria_type' => Feature::TYPE_BOOLEAN, 'criteria_value' => 'yes', 'description' => 'Alertes automatiques multi-canaux'],
            ['name' => 'Notifications Email/SMS', 'criteria' => 'email-sms-notifications', 'criteria_type' => Feature::TYPE_BOOLEAN, 'criteria_value' => 'no', 'description' => 'Notifications non disponibles'],

            // Intégrations (coût: développement + maintenance)
            ['name' => 'Intégrations Tierces', 'criteria' => 'third-party-integrations', 'criteria_type' => Feature::TYPE_BOOLEAN, 'criteria_value' => 'yes', 'description' => 'API REST, ERP, Comptabilité'],
            ['name' => 'Intégrations Tierces', 'criteria' => 'third-party-integrations', 'criteria_type' => Feature::TYPE_BOOLEAN, 'criteria_value' => 'no', 'description' => 'Intégrations tierces non disponibles'],

            // Support (coût: ressources humaines)
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

        // Create plans with strategic pricing
        $plans = [
            [
                'name' => 'Starter',
                'slug' => 'starter',
                'description' => 'Pour les petites équipes qui débutent',
                'price' => 5000.00,
                'currency' => 'XOF',
                'billing_cycle' => Plan::BILLING_CYCLE_MONTHLY,
                'is_active' => true,
            ],
            [
                'name' => 'Professional',
                'slug' => 'professional',
                'description' => 'Pour les PME en croissance',
                'price' => 25000.00,
                'currency' => 'XOF',
                'billing_cycle' => Plan::BILLING_CYCLE_MONTHLY,
                'is_active' => true,
                'is_recommended' => true,
            ],
            [
                'name' => 'Enterprise',
                'slug' => 'enterprise',
                'description' => 'Pour les grandes entreprises',
                'price' => 75000.00,
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
            case 'starter':
                $this->attachStarterFeatures($plan, $features);
                break;
            case 'professional':
                $this->attachProfessionalFeatures($plan, $features);
                break;
            case 'enterprise':
                $this->attachEnterpriseFeatures($plan, $features);
                break;
        }
    }

    /**
     * Attach features for Starter plan (fonctionnalités de base, coûts minimaux)
     */
    private function attachStarterFeatures(Plan $plan, $features): void
    {
        $starterFeatures = [
            'max-allowed-users' => ['is_enabled' => true],
            'max-allowed-tasks' => ['is_enabled' => true],
            'employee-management' => ['is_enabled' => true],
            'task-management' => ['is_enabled' => true],
            'leave-planning' => ['is_enabled' => true],
            'internal-messaging' => ['is_enabled' => false], // Coût bande passante
            'payroll-access' => ['is_enabled' => false], // Coût calculs complexes
            'cnss-declaration' => ['is_enabled' => false], // Coût intégration API
            'analytics-dashboard' => ['is_enabled' => false], // Coût traitement
            'excel-import-export' => ['is_enabled' => false], // Coût bande passante
            'hr-workflow' => ['is_enabled' => false], // Coût développement
            'email-sms-notifications' => ['is_enabled' => false], // Coût services externes
            'third-party-integrations' => ['is_enabled' => false], // Coût développement
            'priority-support' => ['is_enabled' => true],
        ];

        foreach ($starterFeatures as $criteria => $pivot) {
            $feature = Feature::where('criteria', $criteria)
                ->where('criteria_value', $this->getStarterPlanValue($criteria))
                ->first();

            if ($feature) {
                $plan->features()->syncWithoutDetaching([
                    $feature->id => $pivot,
                ]);
            }
        }
    }

    /**
     * Attach features for Professional plan (fonctionnalités intermédiaires)
     */
    private function attachProfessionalFeatures(Plan $plan, $features): void
    {
        $professionalFeatures = [
            'max-allowed-users' => ['is_enabled' => true],
            'max-allowed-tasks' => ['is_enabled' => true],
            'employee-management' => ['is_enabled' => true],
            'task-management' => ['is_enabled' => true],
            'leave-planning' => ['is_enabled' => true],
            'internal-messaging' => ['is_enabled' => true], // Activé pour PME
            'payroll-access' => ['is_enabled' => true], // Activé pour PME
            'cnss-declaration' => ['is_enabled' => true], // Activé pour PME
            'analytics-dashboard' => ['is_enabled' => true], // Activé pour PME
            'excel-import-export' => ['is_enabled' => true], // Activé pour PME
            'hr-workflow' => ['is_enabled' => false], // Gardé pour Enterprise
            'email-sms-notifications' => ['is_enabled' => false], // Gardé pour Enterprise
            'third-party-integrations' => ['is_enabled' => false], // Gardé pour Enterprise
            'priority-support' => ['is_enabled' => true],
        ];

        foreach ($professionalFeatures as $criteria => $pivot) {
            $feature = Feature::where('criteria', $criteria)
                ->where('criteria_value', $this->getProfessionalPlanValue($criteria))
                ->first();

            if ($feature) {
                $plan->features()->syncWithoutDetaching([
                    $feature->id => $pivot,
                ]);
            }
        }
    }

    /**
     * Attach features for Enterprise plan (toutes les fonctionnalités)
     */
    private function attachEnterpriseFeatures(Plan $plan, $features): void
    {
        $enterpriseFeatures = [
            'max-allowed-users' => ['is_enabled' => true],
            'max-allowed-tasks' => ['is_enabled' => true],
            'employee-management' => ['is_enabled' => true],
            'task-management' => ['is_enabled' => true],
            'leave-planning' => ['is_enabled' => true],
            'internal-messaging' => ['is_enabled' => true],
            'payroll-access' => ['is_enabled' => true],
            'cnss-declaration' => ['is_enabled' => true],
            'analytics-dashboard' => ['is_enabled' => true],
            'excel-import-export' => ['is_enabled' => true],
            'hr-workflow' => ['is_enabled' => true], // Exclusif Enterprise
            'email-sms-notifications' => ['is_enabled' => true], // Exclusif Enterprise
            'third-party-integrations' => ['is_enabled' => true], // Exclusif Enterprise
            'priority-support' => ['is_enabled' => true],
        ];

        foreach ($enterpriseFeatures as $criteria => $pivot) {
            $feature = Feature::where('criteria', $criteria)
                ->where('criteria_value', $this->getEnterprisePlanValue($criteria))
                ->first();

            if ($feature) {
                $plan->features()->syncWithoutDetaching([
                    $feature->id => $pivot,
                ]);
            }
        }
    }

    /**
     * Get the criteria value for Starter plan (limitations strictes)
     */
    private function getStarterPlanValue(string $criteria): string
    {
        return match ($criteria) {
            'max-allowed-users' => '2',
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
     * Get the criteria value for Professional plan (limitations modérées)
     */
    private function getProfessionalPlanValue(string $criteria): string
    {
        return match ($criteria) {
            'max-allowed-users' => '5',
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
     * Get the criteria value for Enterprise plan (sans limitations)
     */
    private function getEnterprisePlanValue(string $criteria): string
    {
        return match ($criteria) {
            'max-allowed-users' => 'unlimited',
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