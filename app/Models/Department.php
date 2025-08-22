<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

/**
 * Department Model
 *
 * @property int $id
 * @property int $enterprise_id
 * @property string $name
 * @property bool $active
 * @property string $slug
 * @property bool $late_penalty
 * @property string $work_model
 * @property bool $meeting_participation_score
 * @property bool $attendance_score
 * @property string|null $overtime_recording_score
 * @property string|null $overtime_clocking_score
 * @property int|null $supervisor_id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read Enterprise $enterprise
 * @property-read \Illuminate\Database\Eloquent\Collection|Member[] $members
 * @property-read Member|null $supervisor
 */
class Department extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * Work model constants
     */
    public const WORK_MODEL_REMOTE = 'remote';

    public const WORK_MODEL_HYBRID = 'hybrid';

    public const WORK_MODEL_IN_OFFICE = 'in-office';

    /**
     * Work model options
     */
    public const WORK_MODEL_OPTIONS = [
        self::WORK_MODEL_REMOTE => self::WORK_MODEL_REMOTE,
        self::WORK_MODEL_HYBRID => self::WORK_MODEL_HYBRID,
        self::WORK_MODEL_IN_OFFICE => self::WORK_MODEL_IN_OFFICE,
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'enterprise_id',
        'name',
        'active',
        'slug',
        'late_penalty',
        'work_model',
        'meeting_participation_score',
        'attendance_score',
        'overtime_recording_score',
        'overtime_clocking_score',
        'supervisor_id',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'active' => 'boolean',
        'late_penalty' => 'boolean',
        'meeting_participation_score' => 'boolean',
        'attendance_score' => 'boolean',
    ];

    /**
     * Boot the model and add event listeners.
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($department) {
            if (empty($department->slug)) {
                $department->slug = static::generateUniqueSlug($department->name, $department->enterprise_id);
            }
        });
    }

    /**
     * Generate a unique slug for the department.
     */
    protected static function generateUniqueSlug(string $name, int $enterpriseId): string
    {
        $baseSlug = Str::slug($name);
        $slug = $baseSlug;
        $counter = 1;

        while (static::where('enterprise_id', $enterpriseId)->where('slug', $slug)->exists()) {
            $slug = $baseSlug.'-'.$counter;
            $counter++;
        }

        return $slug;
    }

    /**
     * Get the enterprise that owns the department.
     */
    public function enterprise(): BelongsTo
    {
        return $this->belongsTo(Enterprise::class, 'enterprise_id');
    }

    /**
     * Get the members that belong to the department.
     */
    public function members(): BelongsToMany
    {
        return $this->belongsToMany(Member::class, 'department_member');
    }

    /**
     * Get the supervisor of the department.
     */
    public function supervisor(): BelongsTo
    {
        return $this->belongsTo(Member::class, 'supervisor_id');
    }
}
