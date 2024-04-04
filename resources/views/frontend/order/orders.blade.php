@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>All Book Orders</h1>
        <table class="table">
            <thead>
            <tr>
                <th>User</th>
                <th>Book</th>
            </tr>
            </thead>
            <tbody>
            @foreach($bookOrders as $bookOrder)
                <tr>
                    <td>{{ $bookOrder->user->name }}</td>
                    <td>{{ $bookOrder->book->title }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection
