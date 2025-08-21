<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
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
 * @property string|null $address
 * @property string|null $city
 * @property string|null $state
 * @property string|null $zip_code
 * @property string|null $designation
 * @property \Carbon\Carbon|null $joining_date
 * @property int|null $location_id
 * @property string|null $bank_account_number
 * @property string|null $bank_name
 * @property string|null $pan_number
 * @property string|null $ifsc_code
 * @property string|null $salary_basis
 * @property \Carbon\Carbon|null $effective_date
 * @property float|null $monthly_salary_amount
 * @property string|null $type_of_payment
 * @property float|null $billing_rate
 * @property string|null $job_type
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
 */
class Member extends Model
{
    use HasFactory;

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
        'address',
        'city',
        'state',
        'zip_code',
        'designation',
        'joining_date',
        'location_id',
        'bank_account_number',
        'bank_name',
        'pan_number',
        'ifsc_code',
        'salary_basis',
        'effective_date',
        'monthly_salary_amount',
        'type_of_payment',
        'billing_rate',
        'job_type',
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
        'effective_date' => 'date',
        'status_date' => 'datetime',
        'monthly_salary_amount' => 'decimal:2',
        'billing_rate' => 'decimal:2',
        'status_stories' => 'array',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->code = strtoupper(Str::random(10));
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
}
