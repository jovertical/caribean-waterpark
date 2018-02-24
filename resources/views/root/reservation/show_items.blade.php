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
        <div class="row">
            <div class="col-lg">
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
                                <div class="table-responsive">
                                    <table class="table table-striped m-table w-100">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Name</th>
                                                <th>Quantity</th>
                                                <th>Price</th>
                                                <th></th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                            @foreach($items as $index => $item)
                                                <tr>
                                                    <th scope="row" style="width: 5%;">{{ $index + 1 }}</th>
                                                    <td>{{ ucfirst(strtolower($item->name)) }}</td>
                                                    <th>{{ $item->order_quantity }}</th>
                                                    <th>{{ Helper::moneyFormat($item->order_price) }}</th>
                                                    <th>
                                                        <div data-attribute="confirmable">
                                                            <form method="POST" action="{{ route('root.reservation.remove-item',
                                                                $index) }}" class="confirm" data-target="#removeItem"
                                                                    data-item-index="{{ $index }}" data-item-name="{{ $item->name }}">
                                                                {{ csrf_field() }}

                                                                <input type="hidden" name="quantity" id="quantity_{{ $index }}" value="1">

                                                                <button type="submit" class="btn btn-secondary" data-toggle="modal" data-target="#removeItem" title="Remove item">Remove</button>
                                                            </form>
                                                        </div>
                                                    </th>
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
                                    {{ Helper::moneyFormat($item_costs['price_taxable']) }}
                                </span>
                            </p>

                            <p>
                                <span>SUBTOTAL:</span>

                                <span class="pull-right m--font-bolder">
                                    {{ Helper::moneyFormat($item_costs['price_subtotal']) }}
                                </span>
                            </p>

                            <p>
                                <span>DISCOUNT:</span>

                                <span class="pull-right m--font-bolder">
                                    {{ Helper::moneyFormat($item_costs['price_deductable']) }}
                                </span>
                            </p>
                        </div>

                        <div class="box">
                            <p>
                                <span>TOTAL:</span>

                                <span class="pull-right m--font-boldest">{{ Helper::moneyFormat($item_costs['price_payable']) }}
                                </span>
                            </p>
                        </div>
                    </div>

                    <!-- Bottom -->
                    <div class="m-portlet__foot m-portlet__no-border m-portlet__foot--fit box box-solid">
                        <div class="m-section" style="padding: 2.2rem 2.2rem;">
                            <div class="m-section__content">
                                <div class="d-flex justify-content-end" data-attribute="confirmable">
                                    <div>
                                        <form method="POST" action="{{ route('root.reservation.clear-items') }}" class="confirm"
                                            data-target="#clearItems" style="display: inline-block;">
                                            {{ csrf_field() }}

                                            <button type="submit" data-toggle="modal" data-target="#clearItems" class="btn btn-secondary">Clear cart</button>
                                        </form>

                                        <a href="#" class="btn btn-brand">Checkout</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--/. Bottom -->
                </div>
                <!--end::Portlet-->
            </div>
        </div>
    @endif

    @component('root.components.modal')
        @slot('name')
            removeItem
        @endslot

        @slot('title')
            Confirm action
        @endslot

        @slot('content_position')
            left
        @endslot

        <div class="form-group">
            <label class="form-control-label">Quantity:</label>

            <input type="number" id="quantity" class="form-control" value="1">
        </div>
    @endcomponent

    @component('root.components.modal')
        @slot('name')
            clearItems
        @endslot

        @slot('title')
            Confirm action
        @endslot

        You are removing all the items in the cart. You can't undo this action.
    @endcomponent
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            // modal confirmation
            $('div[data-attribute=confirmable]').on('click', '.confirm', function(e) {
                e.preventDefault();

                var $form = $(this);
                var $modal = $($form.data('target'));
                var $quantity = $('input[id=quantity]');

                $('#modalTitle').text('Remove/decrease in cart: ' + $form.data('item-name'));
                $quantity.on('keyup change', function() {
                    $('input[id=quantity_' + $form.data('item-index') + ']').val($quantity.val());
                });

                $modal.modal({ backdrop: 'static', keyboard: false}).on('click', '#btn-confirm', function() {
                    $form.submit();
                });
            });
        });
    </script>
@endsection