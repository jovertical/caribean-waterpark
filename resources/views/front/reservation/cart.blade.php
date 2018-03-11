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
                            <li class="current">
                                <a href="#">Your Cart</a>
                            </li>
                            <li>
                                <a href="#">Customer information</a>
                            </li>
                            <li>
                                <a href="#">Complete reservation</a>
                            </li>
                        </ul>
                    </div>
                </div>

                <div class="col-lg-9">
                    <div class="checkout-page__content">
                        <!-- Message -->
                        @if (Session::has('message'))
                            @component('front.components.alert')
                                {{ Session::get('message.content') }}
                            @endcomponent
                        @endif

                        @if(count($items) == 0)
                            @component('front.components.alert')
                                There are no items yet. <a href="{{ route('front.reservation.search') }}">Search now?</a>
                            @endcomponent
                        @endif

                        @if(count($items))
                            <div class="yourcart-content">
                                <div class="content-title">
                                    <h2><i class="awe-icon awe-icon-cart"></i>Check Your Cart</h2>
                                </div>
                                <div class="cart-content">
                                    <table class="cart-table">
                                        <thead>
                                            <tr>
                                                <th></th>
                                                <th>Item</th>
                                                <th>Unit Price</th>
                                                <th>Quantity</th>
                                                <th>Total Price</th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                            @foreach($items as $index => $item)
                                                <tr>
                                                    <td class="product-remove">
                                                        <a href="#" onclick="event.preventDefault();
                                                            document.getElementById('form-remove-item').submit();">
                                                            <i class="awe-icon awe-icon-close-o"></i>
                                                        </a>
                                                        <form method="POST" action="
                                                            {{ route('front.reservation.remove-item', $index) }}"
                                                                id="form-remove-item" style="display: none;">
                                                            {{ csrf_field() }}

                                                            <input type="hidden" name="quantity" id="quantity" 
                                                                value="{{ $item->quantity }}">
                                                        </form>
                                                    </td>
                                                    <td class="product-name">
                                                        <span>{{ $item->item->name }}</span>
                                                    </td>
                                                    <td class="product-price">
                                                        <span>{{ Helper::moneyString($item->item->price) }}</span>
                                                    </td>
                                                    <td class="product-quantity">
                                                        <div class="quantity buttons_added">
                                                            <form method="POST" action="
                                                                {{ route('front.reservation.add-item', $item->index) }}">
                                                                {{ csrf_field() }}

                                                                <button type="submit" class="minus">
                                                                    <i class="fa fa-caret-up"></i>
                                                                </button>
                                                            </form>

                                                            <input type="number" class="qty" value="{{ $item->quantity }}">

                                                            <form method="POST" action="
                                                                {{ route('front.reservation.remove-item', $index) }}">
                                                                {{ csrf_field() }}

                                                                <button type="submit" class="plus">
                                                                    <i class="fa fa-caret-down"></i>
                                                                </button>
                                                            </form>
                                                        </div>
                                                    </td>
                                                    <td class="product-subtotal">
                                                        <span class="amount">{{ Helper::moneyString($item->price) }}</span>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>

                                    <div class="cart-footer">
                                        <!-- Vattable -->
                                        <div class="cart-subtotal" style="border: none; padding-bottom: 0;">
                                            <div class="subtotal-title">
                                                <h5>Vattable</h5>
                                            </div>

                                            <div class="subtotal">
                                                <span class="amount">
                                                    {{ Helper::moneyString($item_costs['price_taxable']) }}
                                                </span>
                                            </div>
                                        </div>
                                        <!--/. Vattable -->

                                        <!-- Subtotal -->
                                        <div class="cart-subtotal">
                                            <div class="subtotal-title">
                                                <h5>Subtotal</h5>
                                            </div>
                                            <div class="subtotal">
                                                <span class="amount">
                                                    {{ Helper::moneyString($item_costs['price_subpayable']) }}
                                                </span>
                                                <span class="sale">- 0%</span>
                                            </div>
                                            <div class="coupon-code">
                                                <label for="coupon">Coupon Code</label>
                                                <div class="form-item">
                                                    <input type="text" id="coupon">
                                                </div>
                                                <div class="form-submit">
                                                    <input type="submit" value="Apply code" class="button">
                                                </div>
                                            </div>
                                        </div>
                                        <!--/. Subtotal -->

                                        <!-- Total -->
                                        <div class="order-total">
                                            <h4 class="title">Total</h4>
                                            <span class="amount">
                                                {{ Helper::moneyString($item_costs['price_payable']) }}
                                            </span>
                                        </div>
                                        <!--/. Total -->

                                        <div class="cart-submit">
                                            <!-- Clear cart -->
                                            <input type="submit" value="Clear Cart" class="update-cart"
                                                onclick="event.preventDefault();
                                                    document.getElementById('form-clear-cart').submit();">
                                            <form method="POST" action="{{ route('front.reservation.cart.destroy') }}"
                                                id="form-clear-cart" style="display: none;">
                                                {{ csrf_field() }}
                                            </form>
                                            <!--/. Clear cart -->

                                            <!-- User -->
                                            <input type="submit" value="Continue Checkout" class="checkout"
                                                onclick="event.preventDefault();
                                                    window.location.href='{{ route('front.reservation.user') }}'">
                                        </div>

                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection