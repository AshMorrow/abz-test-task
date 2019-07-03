@extends('adminlte::page')

@section('title', 'Employees list')

@section('content_header')
    <h1>Employees</h1>
@stop

@section('content')
    <div class="box box-danger col-md-6">
        <div class="box-header">
            <h3 class="box-title">Employees list</h3>
            <a href="{!! route('employees.edit') !!}" class="btn btn-warning btn-flat pull-right">Create</a>
        </div>
        <div class="box-body">
            <table class="table table-bordered" id="employees_table">
                <thead>
                    <tr>
                        <th>id</th>
                        <th>Photo</th>
                        <th>Name</th>
                        <th>Position</th>
                        <th>Date of employment</th>
                        <th>Phone</th>
                        <th>Email</th>
                        <th>Salary</th>
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
    var $currentDataTable = $('#employees_table').DataTable({
        processing: true,
        serverSide: true,
        ajax: '{!! route('employees.data') !!}',
        columns: [
            { data: 'id', name: 'id'},
            { data: 'photo', name: 'photo', orderable: false, searchable: false, width: '70px'},
            { data: 'name', name: 'name' },
            { data: 'position_name', name: 'position.name' },
            { data: 'employment_date', name: 'employment_date' },
            { data: 'phone', name: 'phone' },
            { data: 'email', name: 'email' },
            { data: 'salary', name: 'salary' },
            { data: 'action', name: 'action', orderable: false, searchable: false},
        ],
    });
</script>
@endpush
