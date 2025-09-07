<?php

namespace App\Services\Tasks;

use App\Models\Task;
use Illuminate\Support\Facades\DB;

class TaskService
{
    /**
     * Store a new task
     */
    public function store(array $data): Task
    {
        try {
            DB::beginTransaction();

            // Use provided priority or default to 'medium'
            $priority = $data['priority'] ?? 'medium';

            $task = Task::create([
                'name' => $data['name'],
                'project_id' => $data['project_id'],
                'project_lead_id' => $data['project_lead_id'] ?? null,
                'due_date' => $data['due_date'] ?? null,
                'start_time' => $data['start_time'] ?? null,
                'end_time' => $data['end_time'] ?? null,
                'priority' => $priority,
                'assigned_to' => $data['assigned_to'] ?? null,
                'created_by' => auth()->id(),
                'attachments' => $data['attachments'] ?? null,
                'notifications' => $data['notifications'] ?? false,
                'status' => 'todo',
            ]);

            DB::commit();

            return $task->load(['project', 'creator', 'projectLead', 'assignedUser']);
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

    /**
     * Update an existing task
     */
    public function update(int $taskId, array $data): Task
    {
        try {
            DB::beginTransaction();

            $task = Task::findOrFail($taskId);

            // Use provided priority or keep current priority
            if (isset($data['priority'])) {
                $data['priority'] = $data['priority'] ?? $task->priority;
            }

            $task->update(array_filter($data, function ($value) {
                return $value !== null;
            }));

            DB::commit();

            return $task->load(['project', 'creator', 'projectLead', 'assignedUser']);
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
    }
}