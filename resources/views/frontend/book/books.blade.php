@extends('frontend.layouts.app')

@section('title', __('Books'))

@section('content')
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
                            <form action="{{ route('frontend.orders.orders', ['book' => $book->id, 'user' => auth() -> id()]) }}" method="POST">
                                @csrf
                                <button type="submit">Order</button>
                            </form>
                        </td>
                    @endauth
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection
