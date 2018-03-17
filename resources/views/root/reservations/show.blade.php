@extends('root.layouts.main')

@section('sidebar')
    @component('root.components.sidebar')
        <!-- Transactions -->
        <li class="m-menu__item" aria-haspopup="true">
            <a href="{{ route('root.reservations.transactions.index', $reservation) }}" class="m-menu__link">
                <i class="m-menu__link-icon la la-exchange"></i>
                <span class="m-menu__link-title">
                    <span class="m-menu__link-wrap">
                        <span class="m-menu__link-text">Transactions</span>

                        <span class="m-menu__link-badge">
                            <span class="m-badge m-badge--success">{{ count($reservation->transactions) }}</span>
                        </span>
                    </span>
                </span>
            </a>
        </li>
        <!--/. Transactions -->

        <!-- Add payment -->
        @if(! $reservation->fully_paid)
            <li class="m-menu__item" aria-haspopup="true">
                <a href="javascript:void(0);" class="m-menu__link add-payment"
                    data-form="#addPayment"
                    data-action="{{ route('root.reservations.transactions.store', $reservation) }}"
                    data-toggle="modal"
                    data-target="#addPaymentConfirmation"
                >
                    <i class="m-menu__link-icon la la-money"></i>
                    <span class="m-menu__link-title">
                        <span class="m-menu__link-text">Add payment</span>
                    </span>
                </a>
            </li>
        @endif
        <!--/. Add payment -->

        <!-- Print -->
        <li class="m-menu__item" aria-haspopup="true">
            <a href="javascript:void(0);" class="m-menu__link">
                <i class="m-menu__link-icon la la-print"></i>
                <span class="m-menu__link-title">
                    <span class="m-menu__link-text">Print</span>
                </span>
            </a>
        </li>
        <!--/. Print -->

        <!-- Days -->
        <li class="m-menu__item" aria-haspopup="true">
            <a href="{{ route('root.reservations.days.index', $reservation) }}" class="m-menu__link">
                <i class="m-menu__link-icon la la-calendar-o"></i>
                <span class="m-menu__link-title">
                    <span class="m-menu__link-text">Days</span>
                </span>
            </a>
        </li>
        <!--/. Days -->

        @if(in_array(strtolower($reservation->status), ['paid', 'reserved']))
            <!-- Enter -->
            @if((! $reservation->has_entered) AND ($reservation->day != null) AND ((! $reservation->has_exited)))
                <li class="m-menu__item" aria-haspopup="true">
                    <a href="javascript:void(0);"
                        class="m-menu__link reservation-day-to-entered"
                        title="Set reservation day to entered"
                        data-form="#reservationDayToEntered"
                        data-action="{{ route('root.reservations.days.update', $reservation->day) }}"
                        data-toggle="modal"
                        data-target="#reservationDayToEnteredConfirmation"
                        data-reservation-user="{{ $reservation->user->titled_full_name }}"
                        data-reservation-day-adult_quantity="{{ $reservation->day->adult_quantity }}"
                        data-reservation-day-children_quantity="{{ $reservation->day->children_quantity }}">
                        <i class="m-menu__link-icon la la-sign-out"></i>
                        <span class="m-menu__link-title">
                            <span class="m-menu__link-text">Enter</span>
                        </span>
                    </a>
                </li>
            @endif
            <!--/. Enter -->

            <!-- Exit -->
            @if(($reservation->has_entered) AND ($reservation->day != null) AND (! $reservation->has_exited))
                <li class="m-menu__item" aria-haspopup="true">
                    <a href="javascript:void(0);"
                        class="m-menu__link reservation-day-to-exited"
                        title="Set reservation day to exited"
                        data-form="#reservationDayToExited"
                        data-action="{{ route('root.reservations.days.update', $reservation->day) }}"
                        data-toggle="modal"
                        data-target="#reservationDayToExitedConfirmation"
                        data-reservation-user="{{ $reservation->user->titled_full_name }}">

                        <i class="m-menu__link-icon la la-sign-in"></i>
                        <span class="m-menu__link-title">
                            <span class="m-menu__link-text">Exit</span>
                        </span>
                    </a>
                </li>
            @endif
            <!--/. Exit -->
        @endif
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
                                                        @if(in_array(strtolower($reservation->status), ['reserved', 'pending']))
                                                            <li class="m-nav__item">
                                                                <a href="javascript:void(0);"
                                                                    class="m-nav__link update-reservation-to-paid"
                                                                    data-form="#updateReservationToPaid"
                                                                    data-action="{{ route('root.reservations.update', $reservation) }}"
                                                                    data-toggle="modal"
                                                                    data-target="#updateReservationToPaidConfirmation"
                                                                    data-status="paid"
                                                                    data-reservation-user="{{ $reservation->user->titled_full_name }}"
                                                                    title="Set to paid">
                                                                    <span class="m-nav__link-text">Set to
                                                                        <strong class="m--font-success">Paid</strong>
                                                                    </span>
                                                                </a>
                                                            </li>
                                                        @endif

                                                        @if(in_array(strtolower($reservation->status), ['pending']))
                                                            <li class="m-nav__item">
                                                                <a href="javascript:void(0);"
                                                                    class="m-nav__link update-reservation-to-reserved"
                                                                    data-form="#updateReservationToReserved"
                                                                    data-action="{{ route('root.reservations.update', $reservation) }}"
                                                                    data-toggle="modal"
                                                                    data-target="#updateReservationToReservedConfirmation"
                                                                    data-status="reserved"
                                                                    data-reservation-user="{{ $reservation->user->titled_full_name }}"
                                                                    title="Set to reserved">
                                                                    <span class="m-nav__link-text">Set to
                                                                        <strong class="m--font-info">Reserved</strong>
                                                                    </span>
                                                                </a>
                                                            </li>
                                                        @endif

                                                        @if(! in_array(strtolower($reservation->status), ['cancelled', 'void']))
                                                            <li class="m-nav__item">
                                                                <a href="javascript:void(0);"
                                                                    class="m-nav__link update-reservation-to-cancelled"
                                                                    data-form="#updateReservationToCancelled"
                                                                    data-action="{{ route('root.reservations.update', $reservation) }}"
                                                                    data-toggle="modal"
                                                                    data-target="#updateReservationToCancelledConfirmation"
                                                                    data-status="cancelled"
                                                                    data-reservation-user="{{ $reservation->user->titled_full_name }}"
                                                                    title="Set to cancelled">
                                                                    <span class="m-nav__link-text">Set to
                                                                        <strong class="m--font-danger">Cancelled</strong>
                                                                    </span>
                                                                </a>
                                                            </li>
                                                        @endif
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
                                    <img  src="/root/assets/app/media/img/misc/invoice_logo.png" style="width: 200px;">
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
                                        {{ $reservation->name }}
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
                                            <td>{{ Helper::moneyString($item->price_original) }}</td>
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
                                    <span>{{ $reservation->day_count }}</span>
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

    <!-- Add Payment Modal -->
    @component('root.components.modal')
        @slot('name')
            addPaymentConfirmation
        @endslot
        @slot('title')
            Add payment
        @endslot
        @slot('height')
            200
        @endslot
        @slot('content_position')
            left
        @endslot
        @slot('scrollable')
            false
        @endslot

        <form method="POST" action="" class="m-form m-form--fit" id="addPayment">
            {{ csrf_field() }}

            <!-- Transaction type -->
            <input type="hidden" name="transaction_type" id="transaction_type" value="payment">

            <!-- Payment mode -->
            <div class="m-form__group form-group">
                <label for="">Payment mode</label>
                <div class="m-radio-list">
                    <label class="m-radio">
                        <input type="radio" name="payment_mode" id="payment_mode_full" value="full"
                            data-value="{{ Helper::moneyString($reservation->price_left_payable) }}" checked>Full
                        <span></span>
                    </label>
                    @if (count($reservation->transactions) == 0)
                        <label class="m-radio">
                            <input type="radio" name="payment_mode" id="payment_mode_partial" value="partial"
                                data-value="{{ Helper::moneyString($reservation->price_partial_payable) }}">Partial
                            <span></span>
                        </label>
                    @endif
                </div>
            </div>
            <!--/. Payment mode -->

            <!-- Transaction amount -->
            <div class="m-form__group form-group">
                <label class="form-control-label">Amount: </label>

                <input type="text" id="transaction_amount" class="form-control m-input"
                    value="{{ Helper::moneyString($reservation->price_left_payable) }}" readonly>
            </div>
            <!--/. Transaction amount -->

            <!-- Notify user -->
            <div class="m-form__group form-group">
                <div class="m-checkbox-list">
                    <label class="m-checkbox">
                        <input type="checkbox" name="notify_user" id="notify_user" checked>
                            Notify customer
                        <span></span>
                    </label>
                </div>
            </div>
            <!--/. Notify user -->
        </form>
    @endcomponent
    <!--/. Add Payment Modal -->

    <!-- Update Reservation to Paid Modal -->
    @component('root.components.modal')
        @slot('name')
            updateReservationToPaidConfirmation
        @endslot

        <div id="reservation-to-paid-modal-text"></div>

        <!-- Update Reservation to Paid Form -->
        <form method="POST" action="" class="m-form m-form--fit" id="updateReservationToPaid">
            {{ method_field('PATCH') }}
            {{ csrf_field() }}
            <input type="hidden" name="status" id="status" class="status">

            <!-- Confirmation -->
            <div class="m-form__group form-group">
                <label class="form-control-label"></label>

                <input type="text" class="form-control m-input input_confirmation">
            </div>
            <!--/. Confirmation -->
        </form>
        <!--/. Update Reservation to Paid Form -->
    @endcomponent
    <!--/. Update Reservation to Paid Modal -->

    <!-- Update Reservation to Reserved Modal -->
    @component('root.components.modal')
        @slot('name')
            updateReservationToReservedConfirmation
        @endslot

        <div id="reservation-to-reserved-modal-text"></div>

        <!-- Update Reservation to Reserved Form -->
        <form method="POST" action="" id="updateReservationToReserved">
            {{ method_field('PATCH') }}
            {{ csrf_field() }}
            <input type="hidden" name="status" id="status" class="status">

            <!-- Confirmation -->
            <div class="m-form__group form-group">
                <label class="form-control-label"></label>

                <input type="text" class="form-control m-input input_confirmation">
            </div>
            <!--/. Confirmation -->
        </form>
    @endcomponent
    <!--/. Update Reservation to Reserved Modal -->

    <!-- Update Reservation to Cancelled Modal -->
    @component('root.components.modal')
        @slot('name')
            updateReservationToCancelledConfirmation
        @endslot

        <div id="reservation-to-cancelled-modal-text"></div>

        <!-- Update Reservation to Cancelled Form -->
        <form method="POST" action="" id="updateReservationToCancelled">
            {{ method_field('PATCH') }}
            {{ csrf_field() }}
            <input type="hidden" name="status" id="status" class="status">

            <!-- Confirmation -->
            <div class="m-form__group form-group">
                <label class="form-control-label"></label>

                <input type="text" class="form-control m-input input_confirmation">
            </div>
            <!--/. Confirmation -->
        </form>
        <!--/. Update Reservation to Cancelled Form -->
    @endcomponent
    <!--/. Update Reservation to Cancelled Modal -->

    <!-- Reservation Day to Entered Modal -->
    @component('root.components.modal')
        @slot('name')
            reservationDayToEnteredConfirmation
        @endslot

        @slot('height')
            200
        @endslot

        <div id="reservation-day-to-entered-modal-text"></div>

        <!-- Reservation Day to Entered Form -->
        <form method="POST" action="" id="reservationDayToEntered" class="m-form m-form--fit">
            {{ method_field('PATCH') }}
            {{ csrf_field() }}
            <input type="hidden" name="status" id="status" value="enter">

            <div class="form-group m-form__group row">
                <div class="col-lg text-left">
                    <label class="form-control-label">Adult:</label>

                    <input type="number" name="adult_quantity" id="adult_quantity" class="form-control m-input">
                </div>

                <div class="col-lg text-left">
                    <label class="form-control-label">Children:</label>

                    <input type="number" name="children_quantity" id="children_quantity" class="form-control m-input">
                </div>
            </div>
        </form>
    @endcomponent
    <!--/. Reservation Day to Entered Modal -->

    <!-- Reservation Day to Exited Modal -->
    @component('root.components.modal')
        @slot('name')
            reservationDayToExitedConfirmation
        @endslot

        <div id="reservation-day-to-exited-modal-text"></div>

        <!-- Reservation Day to Exited Form -->
        <form method="POST" action="" id="reservationDayToExited">
            {{ method_field('PATCH') }}
            {{ csrf_field() }}
            <input type="hidden" name="status" id="status" value="exit">
        </form>
    @endcomponent
    <!--/. Reservation Day to Entered Modal -->

@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            // payment mode
            $('input[name=payment_mode]').on('change', function(e) {
                var status_to_paid_block = $('#status-to-paid-block');
                var status_to_reserved_block = $('#status-to-reserved-block');

                $('input[id=transaction_amount]').val($(this).data('value'));
            });
            //. payment mode

            // -------------------------- Reservation status update modals --------------------------------------//

            // update reservation to paid.
            $('.update-reservation-to-paid').on('click', function(e) {
                e.preventDefault();

                var link = $(this);
                var form = $(link.data('form'));
                var action = link.data('action');
                var modal = $(link.data('target'));
                var status = link.data('status');
                var input_confirmation = $('.input_confirmation');
                var reservation = {
                    'user' : link.data('reservation-user')
                };

                // assign action to hidden form action attribute.
                form.attr({action: action});

                // set status of the hidden form input.
                $('.status').val(status);

                // set the confirm button to disabled.
                $('.btn-confirm').attr('disabled', true);

                // assign data value
                input_confirmation.data('value', reservation.user);

                // check for existing input confirmation value.
                if (input_confirmation.val() == reservation.user) {
                    $('.btn-confirm').attr('disabled', false);
                }

                // set modal text.
                $('#reservation-to-paid-modal-text').html(
                    '<p>You are setting ' +
                        '<span class="m--font-boldest">' + reservation.user + "</span>'s " +
                        'reservation to <span class="m--font-success">' + status + '</span>. ' +
                        'Please enter the highlighted black text to proceed.' +
                    '</p>'
                );

                modal.modal({ backdrop: 'static', keyboard: false}).on('click', '#btn-confirm', function() {
                    form.submit();
                });
            });
            //. update reservation to paid.

            // update reservation to reserved.
            $('.update-reservation-to-reserved').on('click', function(e) {
                e.preventDefault();

                var link = $(this);
                var form = $(link.data('form'));
                var action = link.data('action');
                var modal = $(link.data('target'));
                var status = link.data('status');
                var input_confirmation = $('.input_confirmation');
                var reservation = {
                    'user' : link.data('reservation-user')
                };

                // assign action to hidden form action attribute.
                form.attr({action: action});

                // set status of the hidden form input.
                $('.status').val(status);

                // assign data value
                input_confirmation.data('value', reservation.user);

                // set the confirm button to disabled.
                $('.btn-confirm').attr('disabled', true);

                // check for existing input confirmation value.
                if (input_confirmation.val() == reservation.user) {
                    $('.btn-confirm').attr('disabled', false);
                }

                // set modal text.
                $('#reservation-to-reserved-modal-text').html(
                    '<p>You are setting ' +
                        '<span class="m--font-boldest">' + reservation.user + "</span>'s " +
                        'reservation to <span class="m--font-info">' + status + '</span>. ' +
                        'Please enter the highlighted black text to proceed.' +
                    '</p>'
                );

                modal.modal({ backdrop: 'static', keyboard: false}).on('click', '#btn-confirm', function() {
                    form.submit();
                });
            });
            //. update reservation to reserved.

            // update reservation to cancelled.
            $('.update-reservation-to-cancelled').on('click', function(e) {
                e.preventDefault();

                var link = $(this);
                var form = $(link.data('form'));
                var action = link.data('action');
                var modal = $(link.data('target'));
                var status = link.data('status');
                var input_confirmation = $('.input_confirmation');
                var reservation = {
                    'user' : link.data('reservation-user')
                };

                // assign action to hidden form action attribute.
                form.attr({action: action});

                // set status of the hidden form input.
                $('.status').val(status);

                // assign data value
                input_confirmation.data('value', reservation.user);

                // set the confirm button to disabled.
                $('.btn-confirm').attr('disabled', true);

                // check for existing input confirmation value.
                if (input_confirmation.val() == reservation.user) {
                    $('.btn-confirm').attr('disabled', false);
                }

                // set modal text.
                $('#reservation-to-cancelled-modal-text').html(
                    '<p>You are setting ' +
                        '<span class="m--font-boldest">' + reservation.user + "</span>'s " +
                        'reservation to <span class="m--font-danger">' + status + '</span>. ' +
                        'Please be noted that this action will make the reservation inactive. ' +
                        'Please enter the highlighted black text to proceed.' +
                    '</p>'
                );

                modal.modal({ backdrop: 'static', keyboard: false}).on('click', '#btn-confirm', function() {
                    form.submit();
                });
            });
            //. update reservation to cancelled.

            //. -------------------------- Reservation status update modals --------------------------------------//

            // -------------------------- Reservation day update modals --------------------------------------//

            // reservation day to entered.
            $('.reservation-day-to-entered').on('click', function(e) {
                e.preventDefault();

                var link = $(this);
                var form = $(link.data('form'));
                var action = link.data('action');
                var modal = $(link.data('target'));
                var reservation = {
                    'user' : link.data('reservation-user'),
                    'day' : {
                        'adult_quantity' : link.data('reservation-day-adult_quantity'),
                        'children_quantity' : link.data('reservation-day-children_quantity')
                    }
                };

                // assign action to hidden form action attribute.
                form.attr({action: action});

                // set adult_quantity input value.
                $('input[id=adult_quantity]').val(reservation.day.adult_quantity);

                // set children_quantity input value.
                $('input[id=children_quantity]').val(reservation.day.children_quantity);

                // set modal text.
                $('#reservation-day-to-entered-modal-text').html(
                    '<p>' +
                        'You are setting <span class="m--font-bolder">' + reservation.user + "'s </span>" +
                        'reservation day to entered. Below are the set number of guests for today,\
                        Be sure to check if these numbers are correct. Thank you.\
                    </p>'
                );

                modal.modal({ backdrop: 'static', keyboard: false}).on('click', '#btn-confirm', function() {
                    form.submit();
                });
            });
            //. reservation day to entered.

            // reservation day to exited.
            $('.reservation-day-to-exited').on('click', function(e) {
                e.preventDefault();

                var link = $(this);
                var form = $(link.data('form'));
                var action = link.data('action');
                var modal = $(link.data('target'));
                var reservation = {
                    'user' : link.data('reservation-user'),
                };

                // assign action to hidden form action attribute.
                form.attr({action: action});

                // set modal text.
                $('#reservation-day-to-exited-modal-text').html(
                    '<p>' +
                        'You are setting <span class="m--font-bolder">' + reservation.user + "'s </span>" +
                        'reservation day to exited. \
                    </p>'
                );

                modal.modal({ backdrop: 'static', keyboard: false}).on('click', '#btn-confirm', function() {
                    form.submit();
                });
            });
            //. reservation day to exited.

            //. -------------------------- Reservation day update modals --------------------------------------//


            // -------------------------- Add payment modal --------------------------------------//
            $('.add-payment').on('click', function(e) {
                e.preventDefault();

                var link = $(this);
                var form = $(link.data('form'));
                var action = link.data('action');
                var modal = $(link.data('target'));

                // assign action to hidden form action attribute.
                form.attr({action: action});

                modal.modal({ backdrop: 'static', keyboard: false}).on('click', '#btn-confirm', function() {
                    form.submit();
                });
            });
            //. -------------------------- Add payment modal --------------------------------------//


            $('.modal').on('hidden.bs.modal', function(e) {
                // re-enable disabled .btn-confirm buttons
                $('.btn-confirm').attr('disabled', false);

                // clear values of input confirmations
                $('.input_confirmation').val('');
            });

            // input confirmation
            $('.input_confirmation').on('change keyup', function(e) {
                if ($(this).val() == $(this).data('value')) {
                    $('.btn-confirm').attr('disabled', false);
                } else {
                    $('.btn-confirm').attr('disabled', true);
                }
            });
        });
    </script>
@endsection