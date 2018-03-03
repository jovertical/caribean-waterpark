@extends('root.layouts.main')

@section('sidebar')
    @component('root.components.sidebar')
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
                                        <th>{{ Helper::moneyFormat($item->price_payable) }}</th>
                                        <th>{{ Helper::moneyFormat($item->price_payable) }}</th>
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
                        {{ Helper::moneyFormat($reservation->price_taxable) }}
                    </span>
                </p>

                <p>
                    <span>SUBTOTAL:</span>

                    <span class="pull-right m--font-bolder">
                        {{ Helper::moneyFormat($reservation->price_subpayable) }}
                    </span>
                </p>

                <p>
                    <span>DISCOUNT:</span>

                    <span class="pull-right m--font-bolder">
                        {{ Helper::moneyFormat($reservation->price_deductable) }}
                    </span>
                </p>
            </div>

            <div class="box">
                <p>
                    <span>TOTAL:</span>

                    <span class="pull-right m--font-boldest">
                        {{ Helper::moneyFormat($reservation->price_payable) }}
                    </span>
                </p>
            </div>
        </div>
        <!--/. Portlet body -->
    </div>
    <!--/. Portlet -->
@endsection

@section('scripts')

@endsection