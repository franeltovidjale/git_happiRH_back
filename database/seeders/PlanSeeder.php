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
        // Create features first based on the HTML table
        $features = [
            // Paie (Payroll)
            ['name' => 'Paie Basique (fiches PDF simples)', 'criteria' => 'payroll', 'criteria_type' => Feature::TYPE_BOOLEAN, 'criteria_value' => 'basic', 'description' => 'Génération de fiches de paie PDF simples'],
            ['name' => 'Paie Basique + fiches PDF', 'criteria' => 'payroll', 'criteria_type' => Feature::TYPE_BOOLEAN, 'criteria_value' => 'standard', 'description' => 'Fiches de paie avec plus de détails'],
            ['name' => 'Paie Avancée et au choix (charges Bénin)', 'criteria' => 'payroll', 'criteria_type' => Feature::TYPE_BOOLEAN, 'criteria_value' => 'advanced', 'description' => 'Calculs avancés avec charges Bénin'],
            ['name' => 'Paie Avancée + intégrations comptables', 'criteria' => 'payroll', 'criteria_type' => Feature::TYPE_BOOLEAN, 'criteria_value' => 'enterprise', 'description' => 'Intégration complète avec la comptabilité'],

            // Congés & absences
            ['name' => 'Congés & absences Basique', 'criteria' => 'leave-management', 'criteria_type' => Feature::TYPE_BOOLEAN, 'criteria_value' => 'basic', 'description' => 'Gestion basique des congés'],
            ['name' => 'Congés & absences Complet', 'criteria' => 'leave-management', 'criteria_type' => Feature::TYPE_BOOLEAN, 'criteria_value' => 'complete', 'description' => 'Gestion complète des congés et absences'],

            // Pointage digital
            ['name' => 'Pointage Simple (entrée/sortie)', 'criteria' => 'time-tracking', 'criteria_type' => Feature::TYPE_BOOLEAN, 'criteria_value' => 'basic', 'description' => 'Pointage simple entrée/sortie'],
            ['name' => 'Pointage Avancé (GPS, QR, anti-triche)', 'criteria' => 'time-tracking', 'criteria_type' => Feature::TYPE_BOOLEAN, 'criteria_value' => 'advanced', 'description' => 'Pointage avec GPS, QR code et anti-triche'],
            ['name' => 'Pointage Avancé + multi-sites', 'criteria' => 'time-tracking', 'criteria_type' => Feature::TYPE_BOOLEAN, 'criteria_value' => 'enterprise', 'description' => 'Pointage avancé pour plusieurs sites'],

            // CNSS
            ['name' => 'CNSS Export & suivi', 'criteria' => 'cnss', 'criteria_type' => Feature::TYPE_BOOLEAN, 'criteria_value' => 'basic', 'description' => 'Export et suivi des déclarations CNSS'],
            ['name' => 'CNSS API (future intégration)', 'criteria' => 'cnss', 'criteria_type' => Feature::TYPE_BOOLEAN, 'criteria_value' => 'api', 'description' => 'Intégration API CNSS (future)'],

            // Planning & tâches
            ['name' => 'Planning & tâches Avancé (multi-équipes)', 'criteria' => 'planning-tasks', 'criteria_type' => Feature::TYPE_BOOLEAN, 'criteria_value' => 'advanced', 'description' => 'Planning et gestion des tâches multi-équipes'],

            // Messagerie interne
            ['name' => 'Messagerie Chat, audio, vidéo', 'criteria' => 'internal-messaging', 'criteria_type' => Feature::TYPE_BOOLEAN, 'criteria_value' => 'standard', 'description' => 'Messagerie avec chat, audio et vidéo'],
            ['name' => 'Messagerie + support prioritaire', 'criteria' => 'internal-messaging', 'criteria_type' => Feature::TYPE_BOOLEAN, 'criteria_value' => 'premium', 'description' => 'Messagerie avec support prioritaire'],

            // Reporting RH
            ['name' => 'Reporting RH Basique', 'criteria' => 'hr-reporting', 'criteria_type' => Feature::TYPE_BOOLEAN, 'criteria_value' => 'basic', 'description' => 'Rapports RH de base'],
            ['name' => 'Reporting RH Avancé', 'criteria' => 'hr-reporting', 'criteria_type' => Feature::TYPE_BOOLEAN, 'criteria_value' => 'advanced', 'description' => 'Rapports RH avancés'],

            // Support client
            ['name' => 'Support Documentation en ligne', 'criteria' => 'support', 'criteria_type' => Feature::TYPE_BOOLEAN, 'criteria_value' => 'documentation', 'description' => 'Support via documentation en ligne'],
            ['name' => 'Support Email / WhatsApp', 'criteria' => 'support', 'criteria_type' => Feature::TYPE_BOOLEAN, 'criteria_value' => 'email-whatsapp', 'description' => 'Support par email et WhatsApp'],
            ['name' => 'Support Email / Chat', 'criteria' => 'support', 'criteria_type' => Feature::TYPE_BOOLEAN, 'criteria_value' => 'email-chat', 'description' => 'Support par email et chat'],
            ['name' => 'Support Prioritaire + visio', 'criteria' => 'support', 'criteria_type' => Feature::TYPE_BOOLEAN, 'criteria_value' => 'priority', 'description' => 'Support prioritaire avec visioconférence'],
        ];

        foreach ($features as $featureData) {
            Feature::updateOrCreate(
                ['criteria' => $featureData['criteria'], 'criteria_value' => $featureData['criteria_value'] ?? null],
                $featureData
            );
        }

        // Create plans based on the HTML table
        $plans = [
            [
                'name' => 'Offre Lite',
                'slug' => 'lite',
                'description' => 'Solution de base pour tester ou petites équipes',
                'target_audience' => 'Test / ≤ 5 employés',
                'price' => 10000.00,
                'price_per_employee' => 0.00,
                'trial_period_months' => 3,
                'is_custom_quote' => false,
                'currency' => 'XOF',
                'billing_cycle' => Plan::BILLING_CYCLE_MONTHLY,
                'is_active' => true,
            ],
            [
                'name' => 'Offre Starter',
                'slug' => 'starter',
                'description' => 'Pour les petites entreprises et start-ups',
                'target_audience' => 'Petites entreprises / start-up (< 10 employés)',
                'price' => 20000.00,
                'price_per_employee' => 0.00,
                'trial_period_months' => 0,
                'is_custom_quote' => false,
                'currency' => 'XOF',
                'billing_cycle' => Plan::BILLING_CYCLE_MONTHLY,
                'is_active' => true,
            ],
            [
                'name' => 'Offre Premium',
                'slug' => 'premium',
                'description' => 'Solution complète pour PME',
                'target_audience' => 'PME (10 à 50 employés)',
                'price' => 40000.00,
                'price_per_employee' => 500.00,
                'trial_period_months' => 0,
                'is_custom_quote' => false,
                'currency' => 'XOF',
                'billing_cycle' => Plan::BILLING_CYCLE_MONTHLY,
                'is_active' => true,
                'is_recommended' => true,
            ],
            [
                'name' => 'Offre Corporate',
                'slug' => 'corporate',
                'description' => 'Solution sur mesure pour grandes entreprises',
                'target_audience' => 'Grandes entreprises (> 50 employés)',
                'price' => 0.00,
                'price_per_employee' => 0.00,
                'trial_period_months' => 0,
                'is_custom_quote' => true,
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
        switch ($plan->slug) {
            case 'lite':
                $this->attachLiteFeatures($plan);
                break;
            case 'starter':
                $this->attachStarterFeatures($plan);
                break;
            case 'premium':
                $this->attachPremiumFeatures($plan);
                break;
            case 'corporate':
                $this->attachCorporateFeatures($plan);
                break;
        }
    }

    /**
     * Attach features for Lite plan
     */
    private function attachLiteFeatures(Plan $plan): void
    {
        $features = [
            'payroll' => 'basic',
            'leave-management' => 'basic',
            'time-tracking' => 'basic',
            'cnss' => 'basic',
            'planning-tasks' => null, // Not available
            'internal-messaging' => null, // Not available
            'hr-reporting' => null, // Not available
            'support' => 'documentation',
        ];

        $this->attachPlanFeatures($plan, $features);
    }

    /**
     * Attach features for Starter plan
     */
    private function attachStarterFeatures(Plan $plan): void
    {
        $features = [
            'payroll' => 'standard',
            'leave-management' => 'complete',
            'time-tracking' => 'advanced',
            'cnss' => 'api',
            'planning-tasks' => null, // Not available
            'internal-messaging' => null, // Not available
            'hr-reporting' => 'basic',
            'support' => 'email-whatsapp',
        ];

        $this->attachPlanFeatures($plan, $features);
    }

    /**
     * Attach features for Premium plan
     */
    private function attachPremiumFeatures(Plan $plan): void
    {
        $features = [
            'payroll' => 'advanced',
            'leave-management' => 'complete',
            'time-tracking' => 'enterprise',
            'cnss' => 'api',
            'planning-tasks' => 'advanced',
            'internal-messaging' => 'standard',
            'hr-reporting' => 'advanced',
            'support' => 'email-chat',
        ];

        $this->attachPlanFeatures($plan, $features);
    }

    /**
     * Attach features for Corporate plan
     */
    private function attachCorporateFeatures(Plan $plan): void
    {
        $features = [
            'payroll' => 'enterprise',
            'leave-management' => 'complete',
            'time-tracking' => 'enterprise',
            'cnss' => 'api',
            'planning-tasks' => 'advanced',
            'internal-messaging' => 'premium',
            'hr-reporting' => 'advanced',
            'support' => 'priority',
        ];

        $this->attachPlanFeatures($plan, $features);
    }

    /**
     * Attach features to a plan
     */
    private function attachPlanFeatures(Plan $plan, array $features): void
    {
        foreach ($features as $criteria => $value) {
            if ($value === null) {
                continue; // Feature not available for this plan
            }

            $feature = Feature::where('criteria', $criteria)
                ->where('criteria_value', $value)
                ->first();

            if ($feature) {
                $plan->features()->syncWithoutDetaching([
                    $feature->id => ['is_enabled' => true],
                ]);
            }
        }
    }
}
