<?php

namespace App\Domains\Book\Http\Controllers\Frontend;

use App\Domains\Book\Models\Book;
use App\Domains\Book\Services\BookService;
use App\Http\Controllers\Controller;
use Exception;
use http\Client\Request;
use Illuminate\Support\Facades\Log;

class BookController extends Controller
{

    protected $bookService;

    public function __construct(BookService $bookService)
    {
        $this->bookService = $bookService;
    }

    public function books()
    {
        $books = Book::all();
        return view('frontend.book.books', ['books' => $books]);
    }

    public function booksByAuthor($authorName)
    {
        $books = Book::where('author', 'LIKE', '%' . $authorName . '%')->get();

        return view('frontend.book.booksByAuthor', ['books' => $books]);
    }

    public function orderBook(Request $request)
    {
        $bookId = $request->input('book_id');
        $userId = $request->input('user_id');

        try {
            $this->bookService->orderBook($userId, $bookId);

            return response()->json(['success' => true, 'message' => 'Book ordered successfully']);
        } catch (Exception $e) {
            Log::error('Error ordering book: ' . $e->getMessage());

            return response()->json(['success' => false, 'message' => 'Failed to order book. Please try again later.'], 500);
        }
    }
}
