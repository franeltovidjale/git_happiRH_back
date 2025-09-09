<?php

namespace Database\Seeders;

use App\Models\Country;
use App\Models\Enterprise;
use App\Models\EnterprisePayment;
use App\Models\Member;
use App\Models\PaymentReminder;
use App\Models\Plan;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DevUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::beginTransaction();

        try {
            // Check if dev user already exists
            $existingUser = User::where('email', 'dev.claudy@gmail.com')->first();
            if ($existingUser) {
                $this->command->info('Dev user already exists. Skipping...');
                DB::rollBack();

                return;
            }

            // Get first active plan or create a basic one if none exists
            $plan = Plan::active()->first();
            if (! $plan) {
                $plan = Plan::create([
                    'name' => 'Plan de Base',
                    'price' => 50000,
                    'price_per_employee' => 5000,
                    'currency' => 'FCFA',
                    'is_active' => true,
                    'is_custom_quote' => false,
                    'max_employees' => 50,
                ]);
                $this->command->info('Created basic plan for dev environment');
            }

            // Get first active country or create Morocco if none exists
            $country = Country::active()->first();
            if (! $country) {
                $country = Country::create([
                    'name' => 'Morocco',
                    'code' => 'MA',
                    'flag' => 'flags/ma.png',
                    'active' => true,
                    'lang' => 'fr',
                ]);
                $this->command->info('Created Morocco country for dev environment');
            }

            // Create dev user
            $user = User::create([
                'email' => 'dev.claudy@gmail.com',
                'phone' => '+212600000000',
                'password' => Hash::make('12345678'),
                'type' => User::TYPE_GERANT,
                'is_deletable' => false,
            ]);

            // Create dev enterprise
            $enterprise = Enterprise::create([
                'name' => 'Entreprise de Développement',
                'email' => 'dev.claudy@gmail.com',
                'phone' => '+212600000000',
                'country_code' => $country->code,
                'plan_id' => $plan->id,
                'status' => Enterprise::STATUS_ACTIVE,
                'status_by' => $user->id,
                'status_date' => now(),
                'gerant_id' => $user->id,
            ]);

            // Set user's active enterprise
            $user->update(['active_enterprise_id' => $enterprise->id]);

            // Create member relationship
            Member::create([
                'enterprise_id' => $enterprise->id,
                'user_id' => $user->id,
                'type' => User::TYPE_GERANT,
                'status' => Member::STATUS_ACTIVE,
                'status_by' => $user->id,
            ]);

            // Calculate next payment date (monthly)
            $nextPaymentDate = now()->addMonth();

            // Create EnterprisePayment record
            EnterprisePayment::create([
                'enterprise_id' => $enterprise->id,
                'payment_date' => now(),
                'next_payment_date' => $nextPaymentDate,
                'amount' => $plan->price,
                'transaction_id' => 'DEV-'.uniqid(),
                'status' => EnterprisePayment::STATUS_PAID,
            ]);

            // Create PaymentReminder records for monthly billing
            $reminderDates = [
                $nextPaymentDate->copy()->subDays(10),
                $nextPaymentDate->copy()->subDays(5),
                $nextPaymentDate->copy()->subDay(),
            ];

            foreach ($reminderDates as $reminderDate) {
                PaymentReminder::create([
                    'enterprise_id' => $enterprise->id,
                    'email' => 'dev.claudy@gmail.com',
                    'phone' => '+212600000000',
                    'alert_date' => $reminderDate,
                ]);
            }

            DB::commit();

            $this->command->info('✅ Dev user created successfully!');
            $this->command->info('📧 Email: dev.claudy@gmail.com');
            $this->command->info('🔑 Password: 12345678');
            $this->command->info('🏢 Enterprise: '.$enterprise->name);

        } catch (\Exception $e) {
            DB::rollBack();
            $this->command->error('❌ Error creating dev user: '.$e->getMessage());
            throw $e;
        }
    }
}
