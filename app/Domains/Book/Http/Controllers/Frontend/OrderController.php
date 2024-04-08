<?php

namespace App\Domains\Book\Http\Controllers\Frontend;

use App\Domains\Auth\Models\User;
use App\Domains\Book\Models\Book;
use App\Domains\Book\Models\Order;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class OrderController extends Controller
{
    public function orders()
    {
        if (Auth::user()->isAdmin()) {
            $orders = Order::paginate(10);
        } else {
            $orders = Auth::user()->orders()->paginate(10);
        }

        return view('frontend.order.orders', ['orders' => $orders]);
    }

    public function store(Request $request)
    {
        $validator = $this->validator($request->all());

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $book = Book::findOrFail($request->input('book_id'));
        $user = User::findOrFail($request->input('user_id'));

        $order = new Order();
        $order->book_id = $book->id;
        $order->user_id = $user->id;
        $order->save();

        return redirect()->back()->withFlashSuccess(__('Order was successfully placed.'));
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'book_id' => ['required', 'exists:books,id'],
            'user_id' => ['required', 'exists:users,id'],
        ]);
    }
}
