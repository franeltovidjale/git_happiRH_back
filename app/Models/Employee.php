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
}