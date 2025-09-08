<?php

namespace App\Services\Projects;

use App\Models\Project;
use Illuminate\Support\Facades\DB;

class ProjectService
{
    /**
     * Store a new project
     */
    public function store(array $data): Project
    {
        try {
            DB::beginTransaction();

            // Determine status: use provided status or determine from date
            $status = $data['status'] ?? $this->determineStatusFromDate();

            $project = Project::create([
                'name' => $data['name'],
                'description' => $data['description'] ?? null,
                'status' => $status,
                'project_lead_id' => $data['project_lead_id'] ?? null,
                'creator_id' => auth()->id(),
            ]);

            DB::commit();

            return $project->load(['creator', 'projectLead']);
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

    /**
     * Update an existing project
     */
    public function update(int $projectId, array $data): Project
    {
        try {
            DB::beginTransaction();

            $project = Project::findOrFail($projectId);

            // If status is not provided, determine from date (or keep current status)
            if (! isset($data['status'])) {
                $data['status'] = $this->determineStatusFromDate();
            }

            $project->update(array_filter($data, function ($value) {
                return $value !== null;
            }));

            DB::commit();

            return $project->load(['creator', 'projectLead']);
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

    /**
     * Determine project status based on current date
     */
    private function determineStatusFromDate(): string
    {
        // Since we're creating a new project, default to draft
        // This logic can be enhanced if start_date/end_date fields are added
        return 'draft';
    }
}
