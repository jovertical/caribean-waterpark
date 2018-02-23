@extends('root.layouts.main')

@section('sidebar')
    @component('root.components.sidebar')
    @endcomponent
@endsection

@section('content')
    <div class="row">
        <div class="col-lg">
            <!--begin::Portlet-->
            <div class="m-portlet">
                <div class="m-portlet__head">
                    <div class="m-portlet__head-caption">
                        <div class="m-portlet__head-title">
                            <h3 class="m-portlet__head-text">
                                Item List
                            </h3>
                        </div>
                    </div>
                </div>
                <div class="m-portlet__body">
                    <!--begin::Section-->
                    <div class="m-section">
                        <div class="m-section__content">
                            <table class="table table-striped m-table">
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
                                            <th>₱{{ Helper::moneyFormat($item->order_price) }}</th>
                                            <th>
                                                <div data-attribute="confirmable">
                                                    <form method="POST" action="{{ route('root.reservations.remove-item', $index) }}" class="confirm" data-item-index="{{ $index }}" data-item-name="{{ $item->name }}">
                                                        {{ csrf_field() }}

                                                        <input type="hidden" name="quantity" id="quantity_{{ $index }}" value="1">

                                                        <button type="submit" class="btn btn-secondary" data-toggle="modal"
                                                            data-target="#modalConfirmation" title="Remove item">Remove</button>
                                                    </form>
                                                </div>
                                            </th>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <!--end::Section-->
                </div>
                <!--end::Form-->
            </div>
            <!--end::Portlet-->
        </div>
    </div>

    @component('root.components.modal_confirmation')
        @slot('title')
            Confirm action
        @endslot

        <div class="form-group">
            <label class="form-control-label">Quantity:</label>

            <input type="number" id="quantity" class="form-control" value="1">
        </div>
    @endcomponent
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            // modal confirmation
            $('div[data-attribute=confirmable]').on('click', '.confirm', function(e) {
                e.preventDefault();

                var $form = $(this);
                var $modal = $("#modalConfirmation");
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