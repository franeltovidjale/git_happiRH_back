<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

/**
 * Employee Model
 *
 * @property int $id
 * @property int $user_id
 * @property int|null $enterprise_id
 * @property int|null $location_id
 * @property bool $active
 * @property \Carbon\Carbon|null $birth_date
 * @property string|null $marital_status
 * @property string|null $gender
 * @property string|null $nationality
 * @property string|null $address
 * @property string|null $city
 * @property string|null $state
 * @property string|null $zip_code
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
 * @property string $employee_id
 * @property string|null $username
 * @property string $role
 * @property string|null $designation
 * @property \Carbon\Carbon $joining_date
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 *
 * @property-read User $user
 * @property-read Enterprise|null $enterprise
 * @property-read Location|null $location
 * @property-read \Illuminate\Database\Eloquent\Collection|Department[] $departments
 * @property-read \Illuminate\Database\Eloquent\Collection|WorkingDay[] $workingDays
 * @property-read \Illuminate\Database\Eloquent\Collection|Experience[] $experiences
 * @property-read \Illuminate\Database\Eloquent\Collection|Document[] $documents
 */
class Employee extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'employer_id',
        'enterprise_id',
        'location_id',
        'active',
        'birth_date',
        'marital_status',
        'gender',
        'nationality',
        'address',
        'city',
        'state',
        'zip_code',
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
        'employee_id',
        'username',
        'role',
        'designation',
        'joining_date',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'active' => 'boolean',
        'birth_date' => 'date',
        'joining_date' => 'date',
        'effective_date' => 'date',
        'monthly_salary_amount' => 'decimal:2',
        'billing_rate' => 'decimal:2',
    ];

    /**
     * Boot the model and add event listeners.
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($employee) {
            if (empty($employee->employee_id)) {
                $employee->employee_id = static::generateEmployeeId();
            }
        });
    }

    /**
     * Generate a unique employee ID.
     *
     * @return string
     */
    protected static function generateEmployeeId(): string
    {
        do {
            $employeeId = 'EMP' . strtoupper(Str::random(8));
        } while (static::where('employee_id', $employeeId)->exists());

        return $employeeId;
    }

    /**
     * Get the user that owns the employee.
     *
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Get the enterprise that owns the employee.
     *
     * @return BelongsTo
     */
    public function enterprise(): BelongsTo
    {
        return $this->belongsTo(Enterprise::class, 'enterprise_id');
    }

    /**
     * Get the location that owns the employee.
     *
     * @return BelongsTo
     */
    public function location(): BelongsTo
    {
        return $this->belongsTo(Location::class, 'location_id');
    }

    /**
     * Get the departments that belong to the employee.
     *
     * @return BelongsToMany
     */
    public function departments(): BelongsToMany
    {
        return $this->belongsToMany(Department::class, 'department_employee');
    }

    /**
     * Get the working days for the employee.
     *
     * @return HasMany
     */
    public function workingDays(): HasMany
    {
        return $this->hasMany(WorkingDay::class, 'employee_id');
    }

    /**
     * Get the experiences for the employee.
     *
     * @return HasMany
     */
    public function experiences(): HasMany
    {
        return $this->hasMany(Experience::class);
    }

    /**
     * Get the documents for the employee.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function documents()
    {
        return $this->morphMany(Document::class, 'documentable');
    }
}