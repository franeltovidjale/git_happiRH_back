<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MemberContactPerson extends Model
{
    use HasFactory;

    protected $table = 'member_contact_persons';

    protected $fillable = [
        'member_id',
        'full_name',
        'phone',
    ];

    public function member(): BelongsTo
    {
        return $this->belongsTo(Member::class);
    }
}
