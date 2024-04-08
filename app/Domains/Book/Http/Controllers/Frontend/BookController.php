<?php

namespace App\Domains\Book\Http\Controllers\Frontend;

use App\Domains\Book\Models\Book;
use App\Domains\Book\Services\BookService;
use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class BookController extends Controller
{

    protected $bookService;

    public function __construct(BookService $bookService)
    {
        $this->bookService = $bookService;
    }

    public function books(Request $request)
    {
        $authorName = $request->input('author');
        if (!empty($authorName)) {
            $books = Book::where('author', 'LIKE', '%' . $authorName . '%')->paginate(10);
        } else {
            $books = Book::paginate(10);
        }

        return view('frontend.book.books', ['books' => $books]);
    }
}
