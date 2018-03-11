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
                                <a href="#">Profile</a>
                            </li>
                            <li>
                                <a href="#">Settings</a>
                            </li>
                            <li>
                                <a href="#">Reservations</a>
                            </li>
                        </ul>
                    </div>
                </div>

                <div class="col-lg-9">
                    <div class="checkout-page__content">
                        <div class="yourcart-content">
                            <div class="content-title">
                                <h2><i class="awe-icon awe-icon-cart"></i>Check Your Cart</h2>
                            </div>

                            <div class="cart-content">
                                <div class="cart-footer">
                                    <div class="cart-subtotal">
                                        <div class="subtotal-title">
                                            <h5>Cart Subtotal</h5>
                                        </div>
                                        <div class="subtotal">
                                            <span class="amount">$ 467.909</span> 
                                            <span class="sale">- 30%</span>
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
                                    <div class="order-total">
                                        <h4 class="title">Order total</h4>
                                        <span class="amount">$ 467.909</span>
                                    </div>
                                    <div class="cart-submit">
                                        <input type="submit" value="Update Cart" class="update-cart"> 
                                        <input type="submit" value="Continue Checkout" class="checkout">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection