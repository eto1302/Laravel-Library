<?php

namespace App\Domains\Book\Http\Controllers\Frontend;

use App\Domains\Book\Models\BookOrder;
use App\Http\Controllers\Controller;

class BookOrderController extends Controller
{
    public function orders()
    {
        $bookOrders = BookOrder::all();

        return view('bookOrders.orders', ['bookOrders' => $bookOrders]);
    }
}
