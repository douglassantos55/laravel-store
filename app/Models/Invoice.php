<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Ramsey\Uuid\Uuid;

class Invoice extends Model
{
    use HasFactory;

    const STATUS_PAID = 'paid';
    const STATUS_PENDING = 'pending';
    const STATUS_CANCELED = 'canceled';
    const STATUS_REFUNDED = 'refunded';

    protected $table = 'invoices';

    protected $keyType = 'uuid';

    public $incrementing = false;

    protected $casts = [
        'due_date' => 'date',
    ];

    protected $fillable = [
        'status',
        'total',
        'payment_method',
        'due_date',
        'invoice_url',
    ];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->id = Uuid::uuid4();
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
