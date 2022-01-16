<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Ramsey\Uuid\Uuid;

class Author extends Model
{
    use HasFactory;

    protected $table = 'authors';

    protected $keyType = 'uuid';

    public $incrementing = false;

    public function __construct() {
        parent::__construct();
        $this->id = Uuid::uuid4();
    }

    public function books() {
        return $this->hasMany(Book::class);
    }
}
