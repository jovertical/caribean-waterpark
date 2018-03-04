@extends('root.layouts.main')

@section('content')
    <div class="container">
        <div class="gateway--info">
            <div class="gateway--desc">
                @if(session()->has('message'))
                    <p class="message">
                        {{ session('message') }}
                    </p>
                @endif
                <p><strong>Order Overview !</strong></p>
                <hr>
                <p>Item : {{ $order['item_name'] }}</p>
                <p>Amount : {{ Helper::moneyString($order['price']) }}</p>
                <hr>
            </div>
            <div class="gateway--paypal">
                <form method="POST" action="/order/pay">
                    {{ csrf_field() }}

                    <button class="btn btn-pay">
                        <i class="la la-paypal" aria-hidden="true"></i> Pay with PayPal
                    </button>
                </form>
            </div>
        </div>
    </div>
@endsection