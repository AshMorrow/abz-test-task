@extends('adminlte::page')

@section('title', 'Position edit')

@section('content')
    <div class="col-md-6">
        <div class="box">
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