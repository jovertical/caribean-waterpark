@extends('root.layouts.main')

@section('sidebar')
    @component('root.components.sidebar')
        <!-- Add payment -->
        <li class="m-menu__item" aria-haspopup="true">
            <a href="javascript:void(0);" class="m-menu__link">
                <i class="m-menu__link-icon la la-money"></i>
                <span class="m-menu__link-title">
                    <span class="m-menu__link-text">Add payment</span>
                </span>
            </a>
        </li>
    @endcomponent
@endsection

@section('content')
    <div class="m-portlet">
        <div class="m-portlet__body m-portlet__body--no-padding">
            <div class="m-invoice-1">
                <div class="m-invoice__wrapper">
                    <div class="m-invoice__head" style="background-image: url(/root/assets/app/media/img/bg/bg-6.jpg);">
                        <div class="d-flex justify-content-end p-4">
                            <ul class="m-portlet__nav">
                                <li class="m-portlet__nav-item m-dropdown m-dropdown--inline m-dropdown--arrow m-dropdown--align-right m-dropdown--align-push" data-dropdown-toggle="hover">
                                    <a href="javascript:void(0);" class="m-portlet__nav-link m-dropdown__toggle
                                    dropdown-toggle btn btn-sm btn-{{ $reservation->status_class }} m-btn m-btn--pill text-white">
                                        <span>{{ $reservation->status }}</span>
                                    </a>

                                    <div class="m-dropdown__wrapper">
                                        <span class="m-dropdown__arrow m-dropdown__arrow--right m-dropdown__arrow--adjust"></span>
                                        <div class="m-dropdown__inner">
                                            <div class="m-dropdown__body">
                                                <div class="m-dropdown__content">
                                                    <ul class="m-nav">
                                                        <li class="m-nav__item">
                                                            <a href="javascript:void(0);"
                                                                class="m-nav__link update-reservation-to-reserved"
                                                                data-form="#updateReservationToReserved"
                                                                data-action="{{ route('root.reservations.update', $reservation) }}"
                                                                data-toggle="modal"
                                                                data-target="#updateReservationToReservedConfirmation"
                                                                data-status="reserved"
                                                                data-reservation-user="{{ $reservation->user->full_name }}"
                                                                title="Set to reserved">
                                                                    <span class="m-nav__link-text">Set to
                                                                        <strong class="m--font-info">Reserved</strong>
                                                                    </span>
                                                            </a>
                                                        </li>

                                                        <li class="m-nav__item">
                                                            <a href="javascript:void(0);"
                                                                class="m-nav__link update-reservation-to-paid"
                                                                data-form="#updateReservationToPaid"
                                                                data-action="{{ route('root.reservations.update', $reservation) }}"
                                                                data-toggle="modal"
                                                                data-target="#updateReservationToPaidConfirmation"
                                                                data-status="paid"
                                                                data-reservation-user="{{ $reservation->user->full_name }}"
                                                                title="Set to paid">
                                                                <span class="m-nav__link-text">Set to
                                                                    <strong class="m--font-success">Paid</strong>
                                                                </span>
                                                            </a>
                                                        </li>

                                                        <li class="m-nav__item">
                                                            <a href="javascript:void(0);"
                                                                class="m-nav__link update-reservation-to-cancelled"
                                                                data-form="#updateReservationToCancelled"
                                                                data-action="{{ route('root.reservations.update', $reservation) }}"
                                                                data-toggle="modal"
                                                                data-target="#updateReservationToCancelledConfirmation"
                                                                data-status="cancelled"
                                                                data-reservation-user="{{ $reservation->user->full_name }}"
                                                                title="Set to cancelled">
                                                                <span class="m-nav__link-text">Set to
                                                                    <strong class="m--font-danger">Cancelled</strong>
                                                                </span>
                                                            </a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div>

                        <div class="m-invoice__container m-invoice__container--centered">
                            <div class="m-invoice__logo">
                                <a href="javascript:void(0);">
                                    <h1>INVOICE</h1>
                                </a>
                                <a href="javascript:void(0);">
                                    <img  src="/root/assets/app/media/img/logos/logo_client_white.png">
                                </a>
                            </div>
                            <span class="m-invoice__desc">
                                <span>{{ $reservation->creator->full_name }}, 80 Parang, Pulong Sampaloc</span>
                                <span>Doña Remedios Trinidad, Bulacan</span>
                            </span>
                            <div class="m-invoice__items">
                                <div class="m-invoice__item">
                                    <span class="m-invoice__subtitle">CREATED</span>
                                    <span class="m-invoice__text">
                                        {{ Carbon::parse($reservation->created_at)->toFormattedDateString() }}
                                    </span>
                                </div>
                                <div class="m-invoice__item">
                                    <span class="m-invoice__subtitle">REFERENCE NO.</span>
                                    <span class="m-invoice__text">
                                        {{ $reservation->reference_number }}
                                    </span>
                                </div>
                                <div class="m-invoice__item">
                                    <span class="m-invoice__subtitle">INVOICE TO:</span>
                                    <span class="m-invoice__text">
                                        {{ $reservation->user->full_name }}, <br>
                                        {{ $reservation->user->address }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="m-invoice__body m-invoice__body--centered">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>DESCRIPTION</th>
                                        <th>QUANTITY</th>
                                        <th>UNIT PRICE</th>
                                        <th>TOTAL PRICE</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($reservation->items as $index => $item)
                                        <tr>
                                            <th scope="row" style="width: 5%;">{{ $index + 1 }}</th>
                                            <td>{{ $item->item->name }}</td>
                                            <td>{{ $item->quantity }}</td>
                                            <td>{{ Helper::moneyString($item->price) }}</td>
                                            <td>{{ Helper::moneyString($item->price_payable) }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="m-invoice__footer">
                        <div class="m-invoice__container m-invoice__container--centered">
                            <div class="m-invoice__content">
                                <span>RESERVATION</span>
                                <span>
                                    <span>Check-in date:</span>
                                    <span>
                                        {{ Carbon::parse($reservation->checkin_date)->toFormattedDateString() }}
                                    </span>
                                </span>

                                <span>
                                    <span>Check-out date:</span>
                                    <span>
                                        {{ Carbon::parse($reservation->checkout_date)->toFormattedDateString() }}
                                    </span>
                                </span>
                                <span>
                                    <span>Days:</span>
                                    <span>{{ $reservation->days }}</span>
                                </span>
                            </div>
                            <div class="m-invoice__content">
                                <span>TOTAL</span>
                                <span class="m-invoice__price">{{ Helper::moneyString($reservation->price_payable) }}</span>
                                <span>*Taxes Included</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Update Reservation to Reserved Form -->
    <form method="POST" action="" id="updateReservationToReserved" style="display: none;">
        {{ method_field('PATCH') }}
        {{ csrf_field() }}
        <input type="hidden" name="status" id="status" class="status">
    </form>

    <!-- Update Reservation to Reserved Modal -->
    @component('root.components.modal')
        @slot('name')
            updateReservationToReservedConfirmation
        @endslot

        <p class="update-reservation-modal-text"></p>
    @endcomponent

    <!-- Update Reservation to Paid Form -->
    <form method="POST" action="" id="updateReservationToPaid" style="display: none;">
        {{ method_field('PATCH') }}
        {{ csrf_field() }}
        <input type="hidden" name="status" id="status" class="status">
    </form>

    <!-- Update Reservation to Paid Modal -->
    @component('root.components.modal')
        @slot('name')
            updateReservationToPaidConfirmation
        @endslot

        <p class="update-reservation-modal-text"></p>
    @endcomponent

    <!-- Update Reservation to Cancelled Form -->
    <form method="POST" action="" id="updateReservationToCancelled" style="display: none;">
        {{ method_field('PATCH') }}
        {{ csrf_field() }}
        <input type="hidden" name="status" id="status" class="status">
    </form>

    <!-- Update Reservation to Cancelled Modal -->
    @component('root.components.modal')
        @slot('name')
            updateReservationToCancelledConfirmation
        @endslot

        <p class="update-reservation-modal-text"></p>
    @endcomponent
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            // update reservation to reserved.
            $('.update-reservation-to-reserved').on('click', function(e) {
                e.preventDefault();

                var link = $(this);
                var form = $(link.data('form'));
                var action = link.data('action');
                var modal = $(link.data('target'));
                var status = link.data('status');
                var reservation = {
                    'user' : link.data('reservation-user')
                };

                // assign action to hidden form action attribute.
                form.attr({action: action});

                // set status of the hidden form input.
                $('.status').val(status);

                // set modal text.
                $('.update-reservation-modal-text').text('You are setting ' +
                    reservation.user + "'s " + 'reservation to ' + status + '.'
                );

                modal.modal({ backdrop: 'static', keyboard: false}).on('click', '#btn-confirm', function() {
                    form.submit();
                });
            });
            //. update reservation to reserved.

            // update reservation to paid.
            $('.update-reservation-to-paid').on('click', function(e) {
                e.preventDefault();

                var link = $(this);
                var form = $(link.data('form'));
                var action = link.data('action');
                var modal = $(link.data('target'));
                var status = link.data('status');
                var reservation = {
                    'user' : link.data('reservation-user')
                };

                // assign action to hidden form action attribute.
                form.attr({action: action});

                // set status of the hidden form input.
                $('.status').val(status);

                // set modal text.
                $('.update-reservation-modal-text').text('You are setting ' +
                    reservation.user + "'s " + 'reservation to ' + status + '.'
                );

                modal.modal({ backdrop: 'static', keyboard: false}).on('click', '#btn-confirm', function() {
                    form.submit();
                });
            });
            //. update reservation to paid.

            // update reservation to cancelled.
            $('.update-reservation-to-cancelled').on('click', function(e) {
                e.preventDefault();

                var link = $(this);
                var form = $(link.data('form'));
                var action = link.data('action');
                var modal = $(link.data('target'));
                var status = link.data('status');
                var reservation = {
                    'user' : link.data('reservation-user')
                };

                // assign action to hidden form action attribute.
                form.attr({action: action});

                // set status of the hidden form input.
                $('.status').val(status);

                // set modal text.
                $('.update-reservation-modal-text').text('You are setting ' +
                    reservation.user + "'s " + 'reservation to ' + status + '.'
                );

                modal.modal({ backdrop: 'static', keyboard: false}).on('click', '#btn-confirm', function() {
                    form.submit();
                });
            });
            //. update reservation to cancelled.
        });
    </script>
@endsection