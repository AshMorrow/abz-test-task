@extends('adminlte::page')

@section('title', 'AdminLTE')

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
            ajax: '{!! $get_list_url !!}',
            columns: [
                { data: 'id', name: 'id' },
                { data: 'name', name: 'name' },
                { data: 'action', name: 'action'},
            ]
        });

    </script>
@endpush
