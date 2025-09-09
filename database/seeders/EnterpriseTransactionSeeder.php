<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class EnterpriseTransactionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Créer des transactions avec des entreprises et utilisateurs existants
        $enterprises = \App\Models\Enterprise::all();
        $users = \App\Models\User::all();

        if ($enterprises->isEmpty() || $users->isEmpty()) {
            $this->command->warn('Aucune entreprise ou utilisateur trouvé. Création de données de base...');

            // Créer quelques entreprises et utilisateurs si nécessaire
            $enterprise = \App\Models\Enterprise::factory()->create();
            $user = \App\Models\User::factory()->create();

            $enterprises = collect([$enterprise]);
            $users = collect([$user]);
        }

        // Créer 50 transactions réparties sur les entreprises existantes
        foreach ($enterprises->take(3) as $enterprise) {
            $enterpriseUsers = $users->random(min($users->count(), 5));

            foreach ($enterpriseUsers as $user) {
                // Transactions complétées (70%)
                \App\Models\EnterpriseTransaction::factory()
                    ->count(rand(3, 8))
                    ->completed()
                    ->create([
                        'enterprise_id' => $enterprise->id,
                        'employer_id' => $user->id,
                    ]);

                // Transactions en attente (20%)
                \App\Models\EnterpriseTransaction::factory()
                    ->count(rand(1, 3))
                    ->pending()
                    ->create([
                        'enterprise_id' => $enterprise->id,
                        'employer_id' => $user->id,
                    ]);

                // Transactions échouées (10%)
                \App\Models\EnterpriseTransaction::factory()
                    ->count(rand(0, 2))
                    ->failed()
                    ->create([
                        'enterprise_id' => $enterprise->id,
                        'employer_id' => $user->id,
                    ]);
            }
        }

        $this->command->info('Transactions d\'entreprise créées avec succès!');
    }
}
