<?php

namespace App\Models;

use App\Contracts\Documentable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\SoftDeletes;

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
class Member extends Model implements Documentable
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
        'department_id',
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
     * @return BelongsTo<Department, Member>
     */
    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class);
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
     * Get the experiences for the member.
     *
     * @return HasMany<Experience>
     */
    public function experiences(): HasMany
    {
        return $this->hasMany(Experience::class);
    }

    /**
     * Get the documents for this member.
     *
     * @return MorphMany<Document>
     */
    public function documents(): MorphMany
    {
        return $this->morphMany(Document::class, 'documentable');
    }

    /**
     * Get the enterprise ID for this documentable model.
     */
    public function getEnterpriseId(): int
    {
        return $this->enterprise_id;
    }

    /**
     * Get the model's ID.
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * Scope to search members by name, email, first name, and phone number.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  string  $search
     */
    public function scopeSearch($query, array $filters): \Illuminate\Database\Eloquent\Builder
    {

        $search = $filters['search'] ?? '';

        // Filter by enterprise if provided
        if (isset($filters['enterprise_id']) && intval($filters['enterprise_id']) > 0) {
            $query->where('enterprise_id', $filters['enterprise_id']);
        }

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

    public function workingHours()
    {
        return $this->hasMany(WorkingHour::class);
    }
}
