@extends('frontend.layouts.app')

@section('title', __('Orders'))

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
            @foreach($orders as $order)
                <tr>
                    <td>{{ $order->user->name }}</td>
                    <td>{{ $order->book->title }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>

    <div style="display: flex; justify-content: center; text-align: center">
        {{$orders->links()}}
    </div>
@endsection
