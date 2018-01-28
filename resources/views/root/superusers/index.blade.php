@extends('root.layouts.main')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md">

            <div class="card mb-4">
                <div class="table-responsive">
                    <div class="card-body p-4">
                        <table id="table" class="table table-striped table-bordered" cellspacing="0" width="100%" data-form="table">

                            <thead>
                                <tr>
                                    <th style="width: 10%;"></th>
                                    <th>Username</th>
                                    <th>Firstname</th>
                                    <th>Lastname</th>
                                    <th>Email address</th>
                                    <th>Last activity</th>
                                    <th>Role</th>
                                    <th>Active</th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach($users as $user)
                                    @include('root.superusers.superuser')
                                @endforeach
                            </tbody>

                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        //DataTable Initialization
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