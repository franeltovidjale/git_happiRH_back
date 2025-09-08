<?php

namespace App\Models;

use App\Enums\TaskPriority;
use App\Enums\TaskStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Task Model
 *
 * @property int $id
 * @property string $name
 * @property int $project_id
 * @property \Carbon\Carbon|null $due_date
 * @property \Carbon\Carbon|null $start_time
 * @property \Carbon\Carbon|null $end_time
 * @property string $priority
 * @property int|null $assigned_to
 * @property int $creator_id
 * @property int $enterprise_id
 * @property array|null $attachments
 * @property bool $notifications
 * @property string $status
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read Project $project
 * @property-read User|null $assignedUser
 * @property-read User $creator
 * @property-read Enterprise $enterprise
 */
class Task extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'project_id',
        'due_date',
        'start_time',
        'end_time',
        'priority',
        'assigned_to',
        'creator_id',
        'enterprise_id',
        'attachments',
        'notifications',
        'status',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'due_date' => 'date',
        'start_time' => 'datetime:H:i',
        'end_time' => 'datetime:H:i',
        'priority' => TaskPriority::class,
        'attachments' => 'array',
        'notifications' => 'boolean',
        'status' => TaskStatus::class,
    ];

    /**
     * Get the project that owns the task.
     */
    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    /**
     * Get the assigned user.
     */
    public function assignedUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    /**
     * Get the creator of the task.
     */
    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'creator_id');
    }

    /**
     * Get the enterprise that owns the task.
     */
    public function enterprise(): BelongsTo
    {
        return $this->belongsTo(Enterprise::class);
    }
}
