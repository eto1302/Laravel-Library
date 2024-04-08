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
            ['title' => 'To Kill a Mockingbird', 'author' => 'Harper Lee', 'year' => 1960, 'genre' => 'Fiction'],
            ['title' => '1984', 'author' => 'George Orwell', 'year' => 1949, 'genre' => 'Dystopian'],
            ['title' => 'The Great Gatsby', 'author' => 'F. Scott Fitzgerald', 'year' => 1925, 'genre' => 'Fiction'],
            ['title' => 'Harry Potter and the Philosopher\'s Stone', 'author' => 'J.K. Rowling', 'year' => 1997, 'genre' => 'Fantasy'],
            ['title' => 'The Catcher in the Rye', 'author' => 'J.D. Salinger', 'year' => 1951, 'genre' => 'Fiction'],
            ['title' => 'The Hobbit', 'author' => 'J.R.R. Tolkien', 'year' => 1937, 'genre' => 'Fantasy'],
            ['title' => 'Animal Farm', 'author' => 'George Orwell', 'year' => 1945, 'genre' => 'Satire'],
            ['title' => 'The Lord of the Rings', 'author' => 'J.R.R. Tolkien', 'year' => 1954, 'genre' => 'Fantasy'],
            ['title' => 'The Da Vinci Code', 'author' => 'Dan Brown', 'year' => 2003, 'genre' => 'Mystery'],
            ['title' => 'The Hunger Games', 'author' => 'Suzanne Collins', 'year' => 2008, 'genre' => 'Science Fiction'],
            ['title' => 'Gone with the Wind', 'author' => 'Margaret Mitchell', 'year' => 1936, 'genre' => 'Historical Fiction'],
            ['title' => 'Brave New World', 'author' => 'Aldous Huxley', 'year' => 1932, 'genre' => 'Dystopian'],
            ['title' => 'The Alchemist', 'author' => 'Paulo Coelho', 'year' => 1988, 'genre' => 'Fantasy'],
            ['title' => 'The Hitchhiker\'s Guide to the Galaxy', 'author' => 'Douglas Adams', 'year' => 1979, 'genre' => 'Science Fiction'],
            ['title' => 'The Chronicles of Narnia', 'author' => 'C.S. Lewis', 'year' => 1950, 'genre' => 'Fantasy']
        ];

        foreach ($popularBooks as $bookData) {
            Book::create($bookData);
        }
    }
}
