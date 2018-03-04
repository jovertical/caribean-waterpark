{{-- @extends('root.layouts.main')

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
    <!-- Portlet -->
    <div class="m-portlet m-portlet--mobile">

        <!-- Portlet head -->
        <div class="m-portlet__head">
            <div class="m-portlet__head-caption">
                <div class="m-portlet__head-title">
                    <span class="m-portlet__head-icon">
                        <i class="flaticon-book"></i>
                    </span>
                    <h3 class="m-portlet__head-text">
                        {{ $reservation->reference_number }}
                    </h3>
                </div>
            </div>

            <div class="m-portlet__head-tools">
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
                                                <a href="#" class="m-nav__link">
                                                    <span class="m-nav__link-text">Set to
                                                        <strong class="m--font-info">Reserved</strong>
                                                    </span>
                                                </a>
                                            </li>
                                            <li class="m-nav__item">
                                                <a href="#" class="m-nav__link">
                                                    <span class="m-nav__link-text">Set to
                                                        <strong class="m--font-success">Paid</strong>
                                                    </span>
                                                </a>
                                            </li>
                                            <li class="m-nav__item">
                                                <a href="#" class="m-nav__link">
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
        </div>
        <!--/. Portlet head -->

        <!-- Portlet body -->
        <div class="m-portlet__body" style="width: 1000px; overflow: auto;">

        </div>
        <!--/. Portlet body -->

        <!-- Portlet body -->
        <div class="m-portlet__body" style="width: 1000px; overflow: auto;">
            <div class="m-section">
                <div class="m-section__content">
                    <div class="table-responsive">
                        <table class="table table-striped m-table w-100">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Quantity</th>
                                    <th>Unit Price</th>
                                    <th>Price Payable</th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach($reservation->items as $index => $item)
                                    <tr>
                                        <th scope="row" style="width: 5%;">{{ $index + 1 }}</th>
                                        <td>{{ ucfirst(strtolower($item->item->name)) }}</td>
                                        <th>{{ $item->quantity }}</th>
                                        <th>{{ Helper::moneyString($item->price) }}</th>
                                        <th>{{ Helper::moneyString($item->price_payable) }}</th>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <!--end::Section-->

            <div class="bordered-box">
                <p>
                    <span>VATTABLE:</span>

                    <span class="pull-right m--font-bolder">
                        {{ Helper::moneyString($reservation->price_taxable) }}
                    </span>
                </p>

                <p>
                    <span>SUBTOTAL:</span>

                    <span class="pull-right m--font-bolder">
                        {{ Helper::moneyString($reservation->price_subpayable) }}
                    </span>
                </p>

                <p>
                    <span>DISCOUNT:</span>

                    <span class="pull-right m--font-bolder">
                        {{ Helper::moneyString($reservation->price_deductable) }}
                    </span>
                </p>
            </div>

            <div class="box">
                <p>
                    <span>TOTAL:</span>

                    <span class="pull-right m--font-boldest">
                        {{ Helper::moneyString($reservation->price_payable) }}
                    </span>
                </p>
            </div>
        </div>
        <!--/. Portlet body -->
    </div>
    <!--/. Portlet -->
@endsection

@section('scripts')

@endsection --}}

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
        <div class="m-portlet__head">
            <div class="m-portlet__head-tools">
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
                                                <a href="#" class="m-nav__link">
                                                    <span class="m-nav__link-text">Set to
                                                        <strong class="m--font-info">Reserved</strong>
                                                    </span>
                                                </a>
                                            </li>
                                            <li class="m-nav__item">
                                                <a href="#" class="m-nav__link">
                                                    <span class="m-nav__link-text">Set to
                                                        <strong class="m--font-success">Paid</strong>
                                                    </span>
                                                </a>
                                            </li>
                                            <li class="m-nav__item">
                                                <a href="#" class="m-nav__link">
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
        </div>

        <div class="m-portlet__body m-portlet__body--no-padding">
            <div class="m-invoice-1">
                <div class="m-invoice__wrapper">
                    <div class="m-invoice__head" style="background-image: url(/root/assets/app/media/img/bg/bg-6.jpg);">
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
                                <span>TOTAL AMOUNT</span>
                                <span class="m-invoice__price">{{ Helper::moneyString($reservation->price_payable) }}</span>
                                <span>*Taxes Included</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection