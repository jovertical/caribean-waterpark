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
                                <h2>My reservations</h2>
                            </div>

                            <div class="cart-content">
                                <table class="cart-table">
                                    <thead>
                                        <tr>
                                            <th>Reference #</th>
                                            <th>Check-in</th>
                                            <th>Check-out</th>
                                            <th>Payable</th>
                                            <th>Paid</th>
                                            <th>Status</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        @foreach($reservations as $index => $reservation)
                                            <tr>
                                                <td>
                                                    <span>{{ $reservation->name }}</span>
                                                </td>
                                                <td>
                                                    <span>{{ $reservation->checkin_date }}</span>
                                                </td>
                                                <td>
                                                    <span>{{ $reservation->checkout_date }}</span>
                                                </td>
                                                <td>
                                                    <span>{{ Helper::moneyString($reservation->price_payable) }}</span>
                                                </td>
                                                <td>
                                                    <span>{{ Helper::moneyString($reservation->price_paid) }}</span>
                                                </td>
                                                <td>
                                                    <span class="text-{{ $reservation->status_class }}">
                                                        {{ $reservation->status }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <a href="{{ route('front.reservations.show', $reservation) }}">
                                                        View details
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>

                                <div class="cart-footer">
                                    <div class="text-center margin-y-5">
                                        <!-- Pagination -->
                                        @if (count($reservations))
                                            {{ $reservations->appends(Request::all())->links('front.components.pagination') }}
                                        @endif
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