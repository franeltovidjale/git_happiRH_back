<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MemberEmployment extends Model
{
    use HasFactory;

    protected $fillable = [
        'member_id',
        'job_type',
        'contract_type',
    ];

    public function member(): BelongsTo
    {
        return $this->belongsTo(Member::class);
    }
}
