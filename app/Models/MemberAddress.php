<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MemberAddress extends Model
{
    use HasFactory;

    protected $fillable = [
        'member_id',
        'address',
        'city',
        'state',
        'zip_code',
    ];

    public function member(): BelongsTo
    {
        return $this->belongsTo(Member::class);
    }
}
