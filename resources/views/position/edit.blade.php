@extends('adminlte::page')

@section('title', 'Position edit')

@section('content')
    <div class="col-md-6">
        <div class="box box-danger">
            <div class="box-header with-border">
                <h3 class="box-title">Position edit</h3>
            </div>
            <form method="post">
                @csrf
                <div class="box-body">
                    <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                        <label for="employee_name">Name</label>
                        <input id="employee_name" name="name" type="text" class="form-control" value="{{ $position->name }}">
                        @if($errors->has('name'))
                            <span class="help-block">{{ $errors->first('name') }}</span>
                        @endif
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-6">
                                <div>
                                    <strong>Created at:</strong>
                                    <span>{{ $position->created_at ? $position->created_at->format('d-m-Y') : '' }}</span>
                                </div>
                                <div>
                                    <strong>Updated at:</strong>
                                    <span>{{ $position->updated_at ? $position->updated_at->format('d-m-Y') : '' }}</span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div>
                                    <strong>Admin created id:</strong>
                                    <span>{{ $position->admin_created_id }}</span>
                                </div>
                                <div>
                                    <strong>Admin updated id:</strong>
                                    <span>{{ $position->admin_updated_id }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="box-footer">
                    <div class="pull-right">
                        <a href="{!! route('positions.list') !!}" class="btn btn-default btn-flat">Cancel</a>
                        <button type="submit" class="btn btn-success btn-flat">Save</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@stop