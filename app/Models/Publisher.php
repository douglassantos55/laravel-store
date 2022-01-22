<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Ramsey\Uuid\Uuid;

class Publisher extends Model
{
    use HasFactory;

    protected $table = 'publishers';

    protected $keyType = 'uuid';

    public $incrementing = false;

    protected $fillable = ['name'];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->id = Uuid::uuid4();
    }

    public function books()
    {
        return $this->hasMany(Book::class);
    }
}
