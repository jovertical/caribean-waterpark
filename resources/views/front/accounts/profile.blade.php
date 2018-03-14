@extends('front.layouts.main')

@section('content')
    <section class="checkout-section-demo">
        <div class="container">
            <div class="row">
                <div class="col-lg-3">
                    @include('front.partials.sidebar')
                </div>

                <div class="col-lg-9">
                    <div class="checkout-page__content">
                        <div class="yourcart-content">
                            <!-- Message -->
                            @if (Session::has('message'))
                                @component('front.components.alert')
                                    {!! Session::get('message.content') !!}
                                @endcomponent
                            @endif

                            <div class="content-title">
                                <h2><i class="awe-icon awe-icon-user"></i>Your profile</h2>
                            </div>

                            <div class="cart-content">
                                <div class="cart-footer">
                                    <div class="cart-submit">
                                        <button type="submit" class="button button-primary">Update</button>
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