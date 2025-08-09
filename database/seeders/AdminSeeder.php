<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        try {
            DB::beginTransaction();

            // Check if admin already exists
            $adminExists = User::where('email', 'admin@happyhr.com')->exists();

            if (!$adminExists) {
                User::create([
                    'first_name' => 'Admin',
                    'last_name' => 'HappyHR',
                    'email' => 'admin@happyhr.com',
                    'phone' => '+1234567890',
                    'password' => Hash::make('password123'),
                    'email_verified_at' => now(),
                    'type' => 'admin',
                    'is_deletable' => false,
                ]);
            } else {
                $this->command->info('Admin user already exists.');
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            $this->command->error('Error creating admin user: ' . $e->getMessage());
        }
    }
}
