<?php

namespace App\Services;

use App\Enums\EnterpriseOptionKey;
use App\Models\WorkingHour;

class WorkingHourService
{
    public function __construct(
        private OptionService $optionService
    ) {}

    /**
     * Fetch a list of working hours with optional filters.
     */
    public function fetchList(array $filters = []): \Illuminate\Database\Eloquent\Collection
    {
        $enterprise = activeEnterprise();

        $query = WorkingHour::where('enterprise_id', $enterprise->id);

        // Filter by member_id if provided
        if (isset($filters['member_id']) && intval($filters['member_id']) > 0) {
            $query->where('member_id', $filters['member_id']);
        }

        return $query->with('member:id,code')->orderBy('weekday')->orderBy('start_hour')->get();
    }

    /**
     * Store a new working hour
     */
    public function store(array $data): WorkingHour
    {
        $data['enterprise_id'] = activeEnterprise()->id;

        return WorkingHour::create($data);
    }

    /**
     * Update an existing working hour
     */
    public function update(int $id, array $data): WorkingHour
    {
        $enterprise = activeEnterprise();

        $workingHour = WorkingHour::where('enterprise_id', $enterprise->id)
            ->where('id', $id)
            ->firstOrFail();

        $workingHour->update($data);

        return $workingHour->fresh();
    }

    /**
     * Create default working hours for a member based on enterprise options
     */
    public function createDefaults(int $memberId): void
    {
        $options = $this->optionService->asArray();

        $workDays = $options[EnterpriseOptionKey::WorkDays->value] ?? [];
        $startWorkTime = $options[EnterpriseOptionKey::StartWorkTime->value] ?? '09:00';
        $endWorkTime = $options[EnterpriseOptionKey::EndWorkTime->value] ?? '17:00';
        $restStartTime = $options[EnterpriseOptionKey::RestStartTime->value] ?? '12:00';
        $restEndTime = $options[EnterpriseOptionKey::RestEndTime->value] ?? '13:00';

        // Check if working hours already exist for this member
        $existingHours = WorkingHour::where('member_id', $memberId)
            ->where('enterprise_id', activeEnterprise()->id)
            ->exists();

        // Don't create default hours if records already exist
        if ($existingHours) {
            return;
        }

        foreach ($workDays as $weekday) {
            // Première période: StartWorkTime à RestStartTime
            WorkingHour::create([
                'member_id' => $memberId,
                'weekday' => $weekday,
                'start_hour' => $startWorkTime,
                'end_hour' => $restStartTime,
                'active' => true,
                'enterprise_id' => activeEnterprise()->id
            ]);

            // Deuxième période: RestEndTime à EndWorkTime
            WorkingHour::create([
                'member_id' => $memberId,
                'weekday' => $weekday,
                'start_hour' => $restEndTime,
                'end_hour' => $endWorkTime,
                'active' => true,
                'enterprise_id' => activeEnterprise()->id
            ]);
        }
    }
}
