<?php

namespace App\Domains\Book\Models;

use App\Domains\Auth\Models\User;
use Database\Factories\OrderFactory;
use Eloquent;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @mixin Eloquent
 * Class Order.
 */
class Order extends Model
{
    use HasFactory;

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

    /**
     * Create a new factory instance for the model.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    protected static function newFactory()
    {
        return OrderFactory::new();
    }
}
