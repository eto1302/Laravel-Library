<?php

namespace Tests\Feature\Frontend;

use App\Domains\Book\Http\Controllers\Frontend\BookController;
use App\Domains\Book\Models\Book;
use Facade\Ignition\DumpRecorder\Dump;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Request;
use Tests\TestCase;

class BookTest extends TestCase
{
    use RefreshDatabase;
    private $bookController;

    public function setUp(): void
    {
        parent::setUp();
        $this->bookController = resolve(BookController::class);
    }

    public function test_books_returns_all_books()
    {
        $request = Request::create('/books', 'GET');
        $response = $this->bookController->books($request);

        $this->assertCount(10, $response->getData()['books']);
    }

    public function test_books_returns_filtered_books_by_author()
    {
        $matchingBook = Book::factory()->create(['author' => 'Test']);

        $request = Request::create('/books?author=Test', 'GET');
        $response = $this->bookController->books($request);

        $this->assertCount(1, $response->getData()['books']);
        $this->assertEquals($matchingBook->getAttribute('id'), $response->getData()['books'][0]->getAttribute('id'));
    }
}
