<?php

namespace App\Services;

use App\Models\Enterprise;
use App\Models\Member;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class EmployeeService
{
    /**
     * Fetch a list of employees with optional filters and snippets.
     */
    public function fetchList(array $filters = [], array $snippets = []): Collection
    {
        $query = Member::query()
            ->where('type', Member::TYPE_EMPLOYEE)
            ->search($filters);
        $snippets = ['user', ...$snippets];

        return $query->get();
    }

    /**
     * Fetch a single employee by ID with optional relationships.
     */
    public function fetchOne(int $id, array $filters = [], array $snippets = []): ?Member
    {
        $query = Member::query()
            ->where('type', Member::TYPE_EMPLOYEE)
            ->search($filters)
            ->where('id', $id);

        $snippets = ['user', ...$snippets];

        if (! empty($snippets)) {
            $query->with($snippets);
        }

        return $query->first();
    }

    /**
     * Store a new employee by creating user and member records.
     */
    public function store(array $validatedData): Member
    {
        return DB::transaction(function () use ($validatedData) {
            // Find the enterprise by code
            $enterprise = Enterprise::where('code', $validatedData['enterprise_code'])->firstOrFail();

            // Create the user
            $user = User::create([
                'first_name' => $validatedData['first_name'],
                'last_name' => $validatedData['last_name'],
                'phone' => $validatedData['phone'] ?? null,
                'email' => $validatedData['email'],
                'password' => Hash::make($validatedData['password']),
                'is_deletable' => true,
            ]);

            // Generate unique username
            $username = $this->generateUniqueUsername($validatedData['first_name'], $validatedData['last_name']);

            // Create the member
            $member = Member::create([
                'enterprise_id' => $enterprise->id,
                'user_id' => $user->id,
                'type' => Member::TYPE_EMPLOYEE,
                'status' => Member::STATUS_REQUESTED,
                'username' => $username,
                'role' => 'employee',
                'birth_date' => $validatedData['birth_date'] ?? null,
                'marital_status' => $validatedData['marital_status'] ?? null,
                'nationality' => $validatedData['nationality'] ?? null,
                'location_id' => $validatedData['location_id'] ?? null,
                'department_id' => $validatedData['department_id'] ?? null,
                'status_by' => $enterprise->owner_id ?? $enterprise->gerant_id ?? $user->id,
                'status_date' => now(),
            ]);

            // Fire the Registered event
            event(new Registered($user));

            return $member->load('user', 'enterprise');
        });
    }

    /**
     * Generate a unique username based on first name and last name.
     */
    private function generateUniqueUsername(string $firstName, string $lastName): string
    {
        $baseUsername = Str::slug($firstName.'.'.$lastName, '.');
        $username = $baseUsername;
        $counter = 1;

        while (Member::where('username', $username)->exists()) {
            $username = $baseUsername.'.'.$counter;
            $counter++;
        }

        return $username;
    }
}
