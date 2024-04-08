@extends('frontend.layouts.app')

@section('title', __('Books'))

@section('content')
    <div style="display: flex; justify-content: center; text-align: center">
        <form action="{{ route('frontend.book.books') }}" method="GET">
            <input type="text" name="author" placeholder="Search by author">
            <button type="submit">Search</button>
        </form>
    </div>

    <div style="display: flex; justify-content: center; text-align: center">
        <table>
            <thead>
            <tr>
                <th>Title</th>
                <th>Author</th>
                <th>Year</th>
                <th>Genre</th>
                @auth
                    <th>Order</th>
                @endauth
            </tr>
            </thead>
            <tbody>
            @foreach($books as $book)
                <tr>
                    <td>{{ $book->title }}</td>
                    <td>{{ $book->author }}</td>
                    <td>{{ $book->year }}</td>
                    <td>{{ $book->genre }}</td>
                    @auth
                        <td>
                            <form action="{{ route('frontend.order.store') }}" method="POST">
                                @csrf
                                <input type="hidden" name="book_id" value="{{ $book->id }}">
                                <input type="hidden" name="user_id" value="{{ auth()->id() }}">
                                <button type="submit">Order</button>
                            </form>
                        </td>
                    @endauth
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>

    <div style="display: flex; justify-content: center; text-align: center">
        {{$books->links()}}
    </div>

@endsection
