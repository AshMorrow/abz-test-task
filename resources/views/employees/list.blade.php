@extends('adminlte::page')

@section('title', 'Employees list')

@section('content_header')
    <h1>Employees</h1>
@stop

@section('content')
    <div class="box col-md-6">
        <div class="box-header">
            <h3 class="box-title">Employees list</h3>
        </div>
        <div class="box-body">
            <table class="table table-bordered" id="employees_table">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Action</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
    @include('modals.delete_modal')
@stop

@push('js')
<script>
    var $table = $('#employees_table').DataTable({
        processing: true,
        serverSide: true,
        ajax: '{!! route('employees.data') !!}',
        columns: [
            { data: 'id', name: 'id' },
            { data: 'name', name: 'name' },
            { data: 'email', name: 'email' },
            { data: 'action', name: 'action'},
        ],
    });

    var $modal = $('#remove_confirmation_modal');
    function showDeletePopup(employeeUrl, employeeName) {
        $modal.find('.modal-title').text('Delete employee');
        $modal.find('.modal-text').html('Are you sure you want to delete ' + '<strong>' + employeeName + '</strong>');
        $modal.attr('action', employeeUrl)
        $modal.modal('show');
    }

    $modal.on('submit', function (e) {
        e.preventDefault();

        $.ajax({
            type: 'POST',
            url: $modal.attr('action'),
            data: $modal.serialize(),
            success: function () {
                $modal.modal('hide');
                $table.ajax.reload(null, false)
            }
        });
    })
</script>
@endpush
