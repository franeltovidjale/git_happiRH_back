<?php

namespace App\Models;

use App\Enums\AbsenceStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * DemandeAbsence Model
 *
 * @property int $id
 * @property \Carbon\Carbon $absence_date
 * @property string $status
 * @property int $member_id
 * @property int $enterprise_id
 * @property int $creator_member_id
 * @property string|null $reason
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read Member $member
 * @property-read Enterprise $enterprise
 * @property-read Member $creator
 */
class DemandeAbsence extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'absence_date',
        'status',
        'member_id',
        'enterprise_id',
        'creator_member_id',
        'reason',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'absence_date' => 'datetime',
        'status' => AbsenceStatus::class,
    ];

    /**
     * Specify the table name.
     */
    protected $table = 'demande_absences';

    /**
     * Get the member associated with the demande absence.
     */
    public function member(): BelongsTo
    {
        return $this->belongsTo(Member::class, 'member_id');
    }

    /**
     * Get the enterprise associated with the demande absence.
     */
    public function enterprise(): BelongsTo
    {
        return $this->belongsTo(Enterprise::class);
    }

    /**
     * Get the creator of the demande absence record.
     */
    public function creator(): BelongsTo
    {
        return $this->belongsTo(Member::class, 'creator_member_id');
    }
}
