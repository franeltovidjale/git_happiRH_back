<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

/**
 * Member Model
 *
 * Represents a member (employee or owner) within an enterprise.
 * Handles the relationship between users and enterprises with additional member-specific data.
 *
 * @property int $id
 * @property int $enterprise_id
 * @property int $user_id
 * @property string $type
 * @property string $status
 * @property string|null $username
 * @property string $code
 * @property \Carbon\Carbon|null $birth_date
 * @property string $marital_status
 * @property string|null $nationality
 * @property string|null $role
 * @property \Carbon\Carbon|null $joining_date
 * @property int|null $location_id
 * @property string|null $status_note
 * @property \Carbon\Carbon|null $status_date
 * @property int $status_by
 * @property array|null $status_stories
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read Enterprise $enterprise
 * @property-read User $user
 * @property-read Location|null $location
 * @property-read User $statusBy
 * @property-read MemberAddress|null $address
 * @property-read MemberBanking|null $banking
 * @property-read MemberSalary|null $salary
 * @property-read MemberEmployment|null $employment
 */
class Member extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * Status constants for member status
     */
    public const STATUS_REQUESTED = 'requested';

    public const STATUS_REJECTED = 'rejected';

    public const STATUS_ACTIVE = 'active';

    public const STATUS_SUSPENDED = 'suspended';

    public const STATUS_TERMINATED = 'terminated';

    /**
     * Type constants for member type
     */
    public const TYPE_EMPLOYEE = 'employee';

    public const TYPE_OWNER = 'owner';

    public const TYPE_HUMAN_RESOURCE = 'human-resource';

    /**
     * Marital status constants
     */
    public const MARITAL_STATUS_SINGLE = 'single';

    public const MARITAL_STATUS_MARRIED = 'married';

    public const MARITAL_STATUS_DIVORCED = 'divorced';

    public const MARITAL_STATUS_WIDOWED = 'widowed';

    /**
     * Job type constants
     */
    public const JOB_TYPE_REMOTE = 'remote';

    public const JOB_TYPE_HYBRID = 'hybrid';

    public const JOB_TYPE_IN_OFFICE = 'in-office';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'enterprise_id',
        'user_id',
        'type',
        'status',
        'username',
        'code',
        'birth_date',
        'marital_status',
        'nationality',
        'role',
        'joining_date',
        'location_id',
        'status_note',
        'status_date',
        'status_by',
        'status_stories',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'birth_date' => 'date',
        'joining_date' => 'date',
        'status_date' => 'datetime',
        'status_stories' => 'array',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function (Member $model) {
            do {
                $code = $model->user_id . str_pad(rand(1, 999999), 4, '0', STR_PAD_LEFT);
            } while (static::where('code', $code)->exists());

            $model->code = $code;
        });
    }

    /**
     * Get the enterprise that owns the member.
     *
     * @return BelongsTo<Enterprise, Member>
     */
    public function enterprise(): BelongsTo
    {
        return $this->belongsTo(Enterprise::class);
    }

    /**
     * Get the user associated with the member.
     *
     * @return BelongsTo<User, Member>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the location associated with the member.
     *
     * @return BelongsTo<Location, Member>
     */
    public function location(): BelongsTo
    {
        return $this->belongsTo(Location::class);
    }

    /**
     * Get the user who last updated the member status.
     *
     * @return BelongsTo<User, Member>
     */
    public function statusBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'status_by');
    }

    /**
     * Get the departments that the member belongs to.
     *
     * @return BelongsToMany<Department, Member>
     */
    public function departments(): BelongsToMany
    {
        return $this->belongsToMany(Department::class, 'department_member');
    }

    /**
     * Get the address information for the member.
     *
     * @return HasOne<MemberAddress>
     */
    public function address(): HasOne
    {
        return $this->hasOne(MemberAddress::class);
    }

    /**
     * Get the banking information for the member.
     *
     * @return HasOne<MemberBanking>
     */
    public function banking(): HasOne
    {
        return $this->hasOne(MemberBanking::class);
    }

    /**
     * Get the salary information for the member.
     *
     * @return HasOne<MemberSalary>
     */
    public function salary(): HasOne
    {
        return $this->hasOne(MemberSalary::class);
    }

    /**
     * Get the employment information for the member.
     *
     * @return HasOne<MemberEmployment>
     */
    public function employment(): HasOne
    {
        return $this->hasOne(MemberEmployment::class);
    }

    /**
     * Get the contact person information for the member.
     *
     * @return HasOne<MemberContactPerson>
     */
    public function contactPerson(): HasOne
    {
        return $this->hasOne(MemberContactPerson::class);
    }

    /**
     * Get the working days for the member.
     *
     * @return HasMany<WorkingDay>
     */
    public function workDays(): HasMany
    {
        return $this->hasMany(WorkingDay::class);
    }

    /**
     * Scope to search members by name, email, first name, and phone number.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string $search
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeSearch($query, array  $filters): \Illuminate\Database\Eloquent\Builder
    {

        $search = $filters['search'] ?? '';

        return $query->when(
            strlen($search) >= 3,
            function ($query) use ($search) {
                $query->whereHas('user', function ($userQuery) use ($search) {
                    $userQuery->where('email', 'like', "%{$search}%")
                        ->orWhere('last_name', 'like', "%{$search}%")
                        ->orWhere('first_name', 'like', "%{$search}%")
                        ->orWhere('phone', 'like', "%{$search}%");
                });
            }
        );
    }
}