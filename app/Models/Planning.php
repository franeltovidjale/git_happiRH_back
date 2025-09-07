<?php

namespace App\Models;

use App\Enums\PlanningStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Planning Model
 *
 * @property int $id
 * @property int $creator_id
 * @property int $assignee_id
 * @property int $member_id
 * @property int $user_id
 * @property \Carbon\Carbon $date_and_time
 * @property string $address
 * @property int|null $task_id
 * @property string $status
 * @property string|null $description
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read User $creator
 * @property-read User $assignee
 * @property-read User $member
 * @property-read User $user
 * @property-read Task|null $task
 */
class Planning extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'creator_id',
        'assignee_id',
        'member_id',
        'user_id',
        'date_and_time',
        'address',
        'task_id',
        'status',
        'description',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'date_and_time' => 'datetime',
        'status' => PlanningStatus::class,
    ];

    /**
     * Get the creator of the planning.
     */
    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'creator_id');
    }

    /**
     * Get the assignee of the planning.
     */
    public function assignee(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assignee_id');
    }

    /**
     * Get the member associated with the planning.
     */
    public function member(): BelongsTo
    {
        return $this->belongsTo(User::class, 'member_id');
    }

    /**
     * Get the user associated with the planning.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Get the task associated with the planning.
     */
    public function task(): BelongsTo
    {
        return $this->belongsTo(Task::class);
    }
}
