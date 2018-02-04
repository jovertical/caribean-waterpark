@extends('root.layouts.main')

@section('styles')
    <!-- Datatables Bootstrap 4 -->
    <link href="/root/assets/jquery/css/datatables.bootstrap4.min.css" rel="stylesheet">
@endsection

@section('content')
    <div class="row">
        <div class="col-md">

            <div class="card">
                <div class="card-body pb-0">
                    <form method="GET" action="{{ route('root.categories.index') }}" class="form-inline pb-0">
                        <!-- Status -->
                        <div class="md-form">
                            <select name="s" id="s" class="mdb-select colorful-select dropdown-default">
                                <option value="" {{ Request::input('s') ==
                                    null ? 'selected disabled' : '' }}>Active</option>
                                <option value="inactive" {{ Request::input('s') ==
                                    'inactive' ? 'selected disabled' : '' }}>Inactive</option>
                                <option value="trashed" {{ Request::input('s') ==
                                    'trashed' ? 'selected disabled' : '' }}>Trashed</option>
                            </select>

                            <label for="s">Status</label>
                        </div>
                        <!--/. Status -->

                        <!-- Submit -->
                        <div class="md-form ml-auto" >
                            <button type="submit" class="btn btn-outline-default mb-0">
                                <i class="fa fa-search mr-1"></i>Filter</button>
                        </div>
                        <!--/. Submit -->
                    </form>
                </div>
            </div>

            <br />

            <!-- Categories Body -->
            <div class="card">
                <div class="table-responsive">
                    <div class="card-body p-4">

                        <table id="table" class="table table-striped table-bordered" cellspacing="0" width="100%" data-form="table">
                            <thead>
                                <tr>
                                    <th style="width: 10%;">Picture</th>
                                    <th>Name</th>
                                    <th>Description</th>
                                    <th style="width: 10%;">Actions</th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach($categories as $index => $category)
                                    @include('root.categories.category')
                                @endforeach
                            </tbody>
                        </table>

                    </div>
                </div>
            </div>
            <!-- Categories Body -->

        </div>
    </div>
@endsection

@section('scripts')
    <!-- Datatables.net -->
    <script src="/root/assets/jquery/js/datatables.min.js"></script>

    <!-- Datatables Bootstrap 4 -->
    <script src="/root/assets/jquery/js/datatables.bootstrap4.min.js"></script>

    <script>
        $(document).ready(function() {
            // DataTable Initialization
            $('#table').DataTable({
                sort: false
            });

            $('table[data-form="table"]').on('click','.form-delete', function(e) {
                e.preventDefault();

                let $form = $(this);

                $('#deleteModal').modal({ backdrop: 'static',
                    keyboard: false}).on('click', '#btn-delete', function() {
                        $form.submit();
                    });
            });

            $('table[data-form="table"]').on('click','.form-toggle', function(e) {
                e.preventDefault();

                let $form = $(this);

                $('#toggleModal').modal({ backdrop: 'static',
                    keyboard: false}).on('click', '#btn-toggle', function() {
                        $form.submit();
                    });
            });

            // Material select init
            $('.mdb-select').material_select();
        });
    </script>
@endsection