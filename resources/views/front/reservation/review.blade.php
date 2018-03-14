@extends('front.layouts.main')

@section('content')
    <section class="checkout-section-demo">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="checkout-page__top">
                        <div class="title">
                            <h1 class="text-uppercase">CHECKOUT</h1>
                        </div>
                        <span class="phone">Support Call: +1-888-8765-1234</span>
                    </div>
                </div>

                <div class="col-lg-3">
                    <div class="checkout-page__sidebar">
                        <ul>
                            <li>
                                <a href="{{ route('front.reservation.cart.index') }}">Your Cart</a>
                            </li>
                            <li>
                                <a href="{{ route('front.reservation.user') }}">Customer information</a>
                            </li>
                            <li class="current">
                                <a href="#">Complete order</a>
                            </li>
                        </ul>
                    </div>
                </div>

                <div class="col-lg-9">
                    <div class="checkout-page__content">
                        <div class="complete-content">
                            <!-- Message -->
                            @if (Session::has('message'))
                                @component('front.components.alert')
                                    {!! Session::get('message.content') !!}
                                @endcomponent
                            @endif

                            <div class="your-order">
                                <h2>Your Reservation</h2>
                                <table class="order-table">
                                    <thead>
                                        <tr>
                                            <th>Reference no.</th>
                                            <th>Check-in</th>
                                            <th>Check-out</th>
                                            <th>Paid</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>{{ $reservation->reference_number }}</td>
                                            <td>{{ Carbon::parse($reservation->checkin_date)->toFormattedDateString() }}</td>
                                            <td>{{ Carbon::parse($reservation->checkout_date)->toFormattedDateString() }}</td>
                                            <td>{{ Helper::moneyString($reservation->price_paid) }}</td>
                                        </tr>
                                    </tbody>
                                </table>

                                <div class="billing-info">
                                    <h3>Billing info</h3>
                                    <table class="billing-table">
                                        <tbody>
                                            <tr>
                                                <td>
                                                    <h4 class="title">Customer name</h4>
                                                    <p>{{ $reservation->user->titled_fullname }}</p>
                                                </td>
                                            </tr>

                                            <tr>
                                                <td>
                                                    <h4 class="title">Email</h4>
                                                    <p>
                                                        <a href="#">{{ $reservation->user->email }}</a>
                                                    </p>
                                                </td>

                                                <td>
                                                    <h4 class="title">Phone</h4>
                                                    <p>{{ $reservation->user->phone_number }}</p>
                                                </td>
                                            </tr>

                                            <tr>
                                                <td>
                                                    <h4 class="title">Address</h4>
                                                    <p>{{ $reservation->user->address }}</p>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>

                                <div class="cart-detail">
                                    <h3>Cart detail</h3>
                                    <table class="cart-detail-table">
                                        <tbody>
                                            <tr>
                                                @foreach($reservation->items as $reservation_item)
                                                    <th>{{ $reservation_item->item->name }}</th>
                                                    <td>{{ Helper::moneyString($reservation_item->price_payable) }}</td>
                                                @endforeach
                                            </tr>
                                        </tbody>

                                        <tfoot>
                                            <tr>
                                                <th>Subtotal</th>
                                                <td>{{ Helper::moneyString($reservation->price_subpayable) }}</td>
                                            </tr>

                                            <tr>
                                                <th>Discount</th>
                                                <td>{{ Helper::moneyString($reservation->price_deductable) }}</td>
                                            </tr>

                                            <tr class="order-total">
                                                <th>Total</th>
                                                <td>
                                                    <span class="amount">
                                                        {{ Helper::moneyString($reservation->price_payable) }}
                                                    </span>
                                                </td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>

                                <div class="your-cart-footer text-right">
                                    <a href="{{ route('front.welcome') }}" class="awe-btn awe-btn-style3">Back to Home</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection