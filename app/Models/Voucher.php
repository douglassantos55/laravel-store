<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Ramsey\Uuid\Uuid;

class Voucher extends Model
{
    use HasFactory;

    const TYPE_FIXED = 'fixed';
    const TYPE_PERCENT = 'percent';

    protected $keyType = 'uuid';

    public $incrementing = false;

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->id = Uuid::uuid4();
    }

    public function orders()
    {
        $this->hasMany(Order::class);
    }

    public function getDiscount(float $value): float
    {
        if ($this->type === self::TYPE_PERCENT) {
            return $this->getPercentageDiscount($value);
        }

        return $this->discount;
    }

    private function getPercentageDiscount(float $value): float
    {
        return $value * ($this->discount / 100);
    }
}
