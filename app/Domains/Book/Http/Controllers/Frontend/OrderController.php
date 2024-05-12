<?php

namespace App\Domains\Book\Http\Controllers\Frontend;

use App\Domains\Book\Models\Order;
use App\Domains\Book\Services\BookService;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class OrderController extends Controller
{

    protected BookService $bookService;

    public function __construct(BookService $bookService)
    {
        $this->bookService = $bookService;
    }
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
        $validator = $this->storeValidator($request->all());

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $result = $this->bookService->orderBook($request->input('user_id'), $request->input('book_id'));

        if (is_string($result)) {
            return redirect()->back()->withErrors($result);
        }
        return redirect()->back()->withFlashSuccess(__('Order was successfully placed.'));
    }

    public function return(Request $request)
    {
        $validator = $this->returnValidator($request->all());

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $result = $this->bookService->returnBook($request->input('order_id'), $request->input('user_id'));

        if (is_string($result)) {
            return redirect()->back()->withErrors($result);
        }
        return redirect()->back()->withFlashSuccess(__('Book was successfully returned.'));
    }

    protected function storeValidator(array $data)
    {
        return Validator::make($data, [
            'book_id' => ['required', 'exists:books,id'],
            'user_id' => ['required', 'exists:users,id'],
        ]);
    }

    protected function returnValidator(array $data)
    {
        return Validator::make($data, [
            'order_id' => ['required', 'exists:orders,id'],
            'user_id' => ['required', 'exists:users,id'],
        ]);
    }
}
