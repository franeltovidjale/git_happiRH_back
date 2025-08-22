<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MemberBanking extends Model
{
    use HasFactory;

    protected $table = 'member_bankings';

    protected $fillable = [
        'member_id',
        'bank_account_number',
        'bank_name',
        'pan_number',
        'ifsc_code',
    ];

    public function member(): BelongsTo
    {
        return $this->belongsTo(Member::class);
    }
}
