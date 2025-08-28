<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MemberSalary extends Model
{
    use HasFactory;

    protected $fillable = [
        'member_id',
        'salary_basis',
        'effective_date',
        'monthly_salary_amount',
        'type_of_payment',
        'billing_rate',
    ];

    protected $casts = [
        'effective_date' => 'date',
        'monthly_salary_amount' => 'decimal:2',
        'billing_rate' => 'decimal:2',
    ];

    public function member(): BelongsTo
    {
        return $this->belongsTo(Member::class);
    }
}
