<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $employee_id
 * @property string $job_title
 * @property string $sector
 * @property string $company_name
 * @property string $start_date
 * @property string|null $end_date
 * @property string|null $responsibilities
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \App\Models\Employee $employee
 */
class Experience extends Model
{
    use HasFactory;

    protected $fillable = [
        'employee_id',
        'job_title',
        'sector',
        'company_name',
        'start_date',
        'end_date',
        'responsibilities',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
    ];

    /**
     * Get the employee that owns the experience.
     */
    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
}
