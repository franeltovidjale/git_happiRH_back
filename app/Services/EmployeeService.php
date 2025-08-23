<?php

namespace App\Services;

use App\Models\Member;
use Illuminate\Database\Eloquent\Collection;

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

        if (!empty($snippets)) {
            $query->with($snippets);
        }

        return $query->first();
    }
}
