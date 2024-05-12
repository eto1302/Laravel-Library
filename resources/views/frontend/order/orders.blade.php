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
                <th>Return Date</th>
                <th>Return Book</th>
            </tr>
            </thead>
            <tbody>
            @foreach($orders as $order)
                <tr>
                    <td>{{ $order->user->name }}</td>
                    <td>{{ $order->book->title }}</td>
                    <td>{{ $order->return_date->format('d-m-Y')  }}</td>
                    @auth
                        <td>
                            <form action="{{ route('frontend.order.return') }}" method="POST">
                                @csrf
                                <input type="hidden" name="order_id" value="{{ $order->id }}">
                                <input type="hidden" name="user_id" value="{{ auth()->id() }}">
                                <button type="submit">Return</button>
                            </form>
                        </td>
                    @endauth
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>

    <div style="display: flex; justify-content: center; text-align: center">
        {{$orders->links()}}
    </div>
@endsection
