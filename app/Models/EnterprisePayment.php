<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EnterprisePayment extends Model
{
    use HasFactory;

    public const STATUS_INIT = 'init';

    public const STATUS_PENDING = 'pending';

    public const STATUS_PAID = 'paid';

    public const STATUS_FAILED = 'failed';

    protected $fillable = [
        'enterprise_id',
        'payment_date',
        'next_payment_date',
        'amount',
        'transaction_id',
        'status',
    ];

    protected $casts = [
        'payment_date' => 'date',
        'next_payment_date' => 'date',
        'amount' => 'decimal:2',
    ];

    public function enterprise()
    {
        return $this->belongsTo(Enterprise::class);
    }
}
