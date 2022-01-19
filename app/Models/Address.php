<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Ramsey\Uuid\Uuid;

class Address extends Model
{
    use HasFactory;

    protected $keyType = 'uuid';

    public $incrementing = false;

    protected $fillable = [
        'zipcode',
        'street',
        'number',
        'complement',
        'neighborhood',
        'city',
        'state',
    ];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->id = Uuid::uuid4();
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
