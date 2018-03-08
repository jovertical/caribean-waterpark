@extends('root.layouts.main')

@section('sidebar')
    @component('root.components.sidebar')
    @endcomponent
@endsection

@section('content')
    @if (! Session::has('message'))
        @if (count($items) == 0)
            @component('root.components.alert')
                @slot('type')
                    warning
                @endslot

                There are no items yet. <a href="{{ route('root.reservation.search-items') }}" class="m-link">Search now?</a>
            @endcomponent
        @endif
    @else
        @component('root.components.alert')
            @slot('type')
                {{ Session::get('message.type') }}
            @endslot

            {{ Session::get('message.body') }}
        @endcomponent
    @endif

    @if (count($items))
        <!--begin::Portlet-->
        <div class="m-portlet">
            <div class="m-portlet__head">
                <div class="m-portlet__head-caption">
                    <div class="m-portlet__head-title">
                        <h3 class="m-portlet__head-text">Item List</h3>
                    </div>
                </div>
            </div>

            <div class="m-portlet__body">
                <div class="m-section">
                    <div class="m-section__content">
                        <table class="table table-responsive table-striped m-table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Description</th>
                                    <th>Quantity</th>
                                    <th>Unit Price</th>
                                    <th>Total Price</th>
                                    <th></th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach($items as $index => $item)
                                    <tr>
                                        <th scope="row" width="5%">{{ $loop->iteration }}</th>
                                        <td>{{ $item->name }}</td>
                                        <td>{{ $item->order_quantity }}</td>
                                        <td>{{ Helper::moneyString($item->price) }}</td>
                                        <td>{{ Helper::moneyString($item->order_price) }}</td>
                                        <td width="25%">
                                            <div class="input-group m-input-group">
                                                <form method="POST" action="{{ route('root.reservation.remove-item', $index) }}"
                                                    class="input-group-append">
                                                    {{ csrf_field() }}

                                                    <input type="hidden" name="quantity" value="1">

                                                    <button type="submit" class="btn btn-secondary">
                                                        <i class="la la-minus"></i>
                                                    </button>
                                                </form>

                                                <input type="number" name="quantity" class="form-control m-input"
                                                    value="{{ $item->order_quantity }}" readonly>

                                                <form method="POST" action="{{ route('root.reservation.add-item', $item->index) }}"
                                                    class="input-group-append">
                                                    {{ csrf_field() }}

                                                    <input type="hidden" name="quantity" value="1">

                                                    <button type="submit" class="btn btn-secondary">
                                                        <i class="la la-plus"></i>
                                                    </button>
                                                </form>

                                                <form method="POST" action="{{ route('root.reservation.remove-item', $index) }}"
                                                    class="input-group-append">
                                                    {{ csrf_field() }}

                                                    <input type="hidden" name="quantity" value="{{ $item->order_quantity }}">

                                                    <button type="submit" class="ml-2 btn btn-danger">X</button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <!--end::Section-->

                <div class="bordered-box">
                    <p>
                        <span>VATTABLE:</span>

                        <span class="pull-right m--font-bolder">
                            {{ Helper::moneyString($item_costs['price_taxable']) }}
                        </span>
                    </p>

                    <p>
                        <span>SUBTOTAL:</span>

                        <span class="pull-right m--font-bolder">
                            {{ Helper::moneyString($item_costs['price_subpayable']) }}
                        </span>
                    </p>

                    <p>
                        <span>DISCOUNT:</span>

                        <span class="pull-right m--font-bolder">
                            {{ Helper::moneyString($item_costs['price_deductable']) }}
                        </span>
                    </p>
                </div>

                <div class="box">
                    <p>
                        <span>TOTAL:</span>

                        <span class="pull-right m--font-boldest">{{ Helper::moneyString($item_costs['price_payable']) }}
                        </span>
                    </p>
                </div>
            </div>

            <!-- Bottom -->
            <div class="m-portlet__foot m-portlet__no-border m-portlet__foot--fit box box-solid">
                <div class="m-section" style="padding: 2.2rem 2.2rem;">
                    <div class="m-section__content">
                        <div class="d-flex justify-content-end">
                            <div>
                                <button type="button" class="btn btn-secondary clear-items"
                                    data-form="#clearItems"
                                    data-action="{{ route('root.reservation.clear-items') }}"
                                    data-toggle="modal"
                                    data-target="#clearItemsConfirmation"
                                    title="Clear items">Clear cart
                                </button>

                                <a href="{{ route('root.reservation.user') }}" class="btn btn-brand">Continue</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--/. Bottom -->
        </div>
        <!--end::Portlet-->
    @endif

    <!-- Clear items Form -->
    <form method="POST" action="" id="clearItems" style="display: none;">
        {{ csrf_field() }}
    </form>
    <!--/. Clear items Form -->

    <!-- Clear items Modal -->
    @component('root.components.modal')
        @slot('name')
            clearItemsConfirmation
        @endslot

        @slot('title')
            Confirm action
        @endslot

        You are removing all the items in the cart. You can't undo this action.
    @endcomponent
    <!--/. Clear items Modal -->
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            // clear items
            $('.clear-items').on('click', function(e) {
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
        });
    </script>
@endsection