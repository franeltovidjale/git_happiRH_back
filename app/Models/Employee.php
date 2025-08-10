<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Employee Model
 *
 * @property int $id
 * @property int $user_id
 * @property int|null $enterprise_id
 * @property bool $active
 * @property \Carbon\Carbon|null $birth_date
 * @property string|null $marital_status
 * @property string|null $gender
 * @property string|null $nationality
 * @property string|null $address
 * @property string|null $city
 * @property string|null $state
 * @property string|null $zip_code
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 *
 * @property-read User $user
 * @property-read Enterprise|null $enterprise
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
        'active',
        'birth_date',
        'marital_status',
        'gender',
        'nationality',
        'address',
        'city',
        'state',
        'zip_code',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'active' => 'boolean',
        'birth_date' => 'date',
    ];

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
}