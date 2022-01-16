<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Ramsey\Uuid\Uuid;

class Book extends Model
{
    use HasFactory;

    protected $table = 'books';

    protected $keyType = 'uuid';

    public $incrementing = false;

    public function __construct() {
        parent::__construct();
        $this->id = Uuid::uuid4();
    }

    public function author() {
        return $this->belongsTo(Author::class);
    }

    public function publisher() {
        return $this->belongsTo(Publisher::class);
    }

    public function category() {
        return $this->belongsTo(Category::class);
    }
}
