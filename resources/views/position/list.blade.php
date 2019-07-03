@extends('adminlte::page')

@section('title', 'Position list')

@section('content_header')
    <h1>Positions</h1>
@stop

@section('content')
    <div class="box box-danger col-md-6">
        <div class="box-header">
            <h3 class="box-title">Position list</h3>
            <a href="{!! route('positions.edit') !!}" class="btn btn-warning btn-flat pull-right">Create</a>
        </div>
        <div class="box-body">
            <table class="table table-bordered" id="employees_table">
                <thead>
                <tr>
                    <th>Name</th>
                    <th>Last update</th>
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
            ajax: '{!! route('positions.data') !!}',
            columns: [
                { data: 'name', name: 'name' },
                { data: 'last_update', name: 'last_update' },
                { data: 'action', name: 'action'},
            ]
        });
    </script>
@endpush
