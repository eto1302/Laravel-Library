<?php

namespace App\Domains\Book\Models;

use App\Domains\Auth\Models\User;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'user_id',
        'book_id',
        'return_date',
        ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function book()
    {
        return $this->belongsTo(Book::class);
    }

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'user_id' => 'integer',
        'book_id' => 'integer',
        'return_date' => 'datetime'
    ];
}
