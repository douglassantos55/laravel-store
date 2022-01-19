<?php

namespace App\Models;

use App\Checkout\PaymentMethod;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Order extends Model
{
    use HasFactory;

    const STATUS_PAID = 'paid';
    const STATUS_PENDING = 'pending';
    const STATUS_CANCELED = 'canceled';
    const STATUS_REFUNDED = 'refunded';

    public function __construct(User $customer, string $deliveryMethod, PaymentMethod $paymentMethod)
    {
        $this->delivery_method = $deliveryMethod;
        $this->paymentMethod = $paymentMethod;
        $this->customer = $customer;
    }

    public function customer()
    {
        return $this->belongsTo(User::class, 'customer_id');
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function voucher()
    {
        return $this->belongsTo(Voucher::class);
    }
}
