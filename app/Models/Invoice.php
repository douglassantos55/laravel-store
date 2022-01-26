<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Ramsey\Uuid\Uuid;

class Invoice extends Model
{
    use HasFactory;

    protected $table = 'invoices';

    protected $keyType = 'uuid';

    public $incrementing = false;

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
