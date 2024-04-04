<?php

namespace App\Domains\Book\Models;

use App\Domains\Auth\Models\User;
use Illuminate\Database\Eloquent\Model;

class BookOrder extends Model
{
    protected $fillable = ['user_id', 'book_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function book()
    {
        return $this->belongsTo(Book::class);
    }
}
