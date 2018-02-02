@extends('root.layouts.main')

@section('styles')
    <!-- Datatables Bootstrap 4 -->
    <link href="/root/assets/jquery/css/datatables.bootstrap4.min.css" rel="stylesheet">
@endsection

@section('content')
    <div class="row">
        <div class="col-md">

            <div class="card">
                <div class="card-body">
                    Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quibusdam blanditiis at placeat illum, voluptatem obcaecati, dignissimos iste libero ipsam nemo cum vero ullam distinctio quo, veniam, facilis consequuntur officia error.
                </div>
            </div>

            <br>

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

        });
    </script>
@endsection