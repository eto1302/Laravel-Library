<?php

namespace Database\Seeders\Book;

use App\Domains\Book\Models\Book;
use Illuminate\Database\Seeder;

class BookSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->initializePopularBooks();
        Book::factory()->count(10)->create();
    }

    private function initializePopularBooks(){
        $popularBooks = [
            ['title' => 'To Kill a Mockingbird', 'author' => 'Harper Lee', 'year' => 1960, 'genre' => 'Fiction', 'quantity' => 5],
            ['title' => '1984', 'author' => 'George Orwell', 'year' => 1949, 'genre' => 'Dystopian', 'quantity' => 5],
            ['title' => 'The Great Gatsby', 'author' => 'F. Scott Fitzgerald', 'year' => 1925, 'genre' => 'Fiction', 'quantity' => 5],
            ['title' => 'Harry Potter and the Philosopher\'s Stone', 'author' => 'J.K. Rowling', 'year' => 1997, 'genre' => 'Fantasy', 'quantity' => 5],
            ['title' => 'The Catcher in the Rye', 'author' => 'J.D. Salinger', 'year' => 1951, 'genre' => 'Fiction', 'quantity' => 4],
            ['title' => 'The Hobbit', 'author' => 'J.R.R. Tolkien', 'year' => 1937, 'genre' => 'Fantasy', 'quantity' => 5],
            ['title' => 'Animal Farm', 'author' => 'George Orwell', 'year' => 1945, 'genre' => 'Satire', 'quantity' => 5],
            ['title' => 'The Lord of the Rings', 'author' => 'J.R.R. Tolkien', 'year' => 1954, 'genre' => 'Fantasy', 'quantity' => 8],
            ['title' => 'The Da Vinci Code', 'author' => 'Dan Brown', 'year' => 2003, 'genre' => 'Mystery', 'quantity' => 0],
            ['title' => 'The Hunger Games', 'author' => 'Suzanne Collins', 'year' => 2008, 'genre' => 'Science Fiction', 'quantity' => 5],
            ['title' => 'Gone with the Wind', 'author' => 'Margaret Mitchell', 'year' => 1936, 'genre' => 'Historical Fiction', 'quantity' => 5],
            ['title' => 'Brave New World', 'author' => 'Aldous Huxley', 'year' => 1932, 'genre' => 'Dystopian', 'quantity' => 1],
            ['title' => 'The Alchemist', 'author' => 'Paulo Coelho', 'year' => 1988, 'genre' => 'Fantasy', 'quantity' => 5],
            ['title' => 'The Hitchhiker\'s Guide to the Galaxy', 'author' => 'Douglas Adams', 'year' => 1979, 'genre' => 'Science Fiction', 'quantity' => 5],
            ['title' => 'The Chronicles of Narnia', 'author' => 'C.S. Lewis', 'year' => 1950, 'genre' => 'Fantasy', 'quantity' => 3]
        ];

        foreach ($popularBooks as $bookData) {
            Book::create($bookData);
        }
    }
}
