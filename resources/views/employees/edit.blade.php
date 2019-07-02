@extends('adminlte::page')

@section('title', 'Employee edit')

@section('content')
    <div class="col-md-6">
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">Employee edit</h3>
            </div>
            <div class="box-body">
                <form method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        @if ($employee->photo)
                            <img src="{!! asset('storage/'.$employee->photo) !!}">
                        @endif
                    </div>
                    <div class="form-group" >
                        <input type="file" name="photo">
                    </div>
                    <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                        <label for="employee_name">Name</label>
                        <input id="employee_name" name="name" type="text" class="form-control" value="{{$employee->name}}" maxlength="255">
                        @if($errors->has('name'))
                            <span class="help-block">{{ $errors->first('name') }}</span>
                        @endif
                    </div>
                    <div class="form-group {{ $errors->has('phone') ? 'has-error' : '' }}">
                        <label for="employee_phone">Phone</label>
                        <input id="employee_phone" name="phone" type="text" class="form-control"  autocomplete="off" value="{{$employee->phone}}">
                        @if($errors->has('phone'))
                            <span class="help-block">{{ $errors->first('phone') }}</span>
                        @endif
                    </div>
                    <div class="form-group {{ $errors->has('email') ? 'has-error' : '' }}">
                        <label for="employee_email">Email</label>
                        <input id="employee_email" name="email" type="email" class="form-control" value="{{$employee->email}}">
                        @if($errors->has('email'))
                            <span class="help-block">{{ $errors->first('email') }}</span>
                        @endif
                    </div>
                    <div class="form-group">
                        <label for="employee_salary">Salary, $</label>
                        <input id="employee_salary" name="salary" type="text" class="form-control" value="{{$employee->salary}}">
                    </div>
                    <div class="form-group">
                        <label for="employee_position">Position</label>
                        <select id="employee_position" name="position_id" type="text" class="form-control">
                            <option value="">---</option>
                            @foreach($positions as $position)
                                <option
                                        value="{{ $position->id }}"
                                        {{ $employee->position_id == $position->id ? 'selected' : '' }}
                                >
                                    {{ $position->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="employee_head">Head</label>
                        <input id="employee_head" type="text" class="form-control" value="{{ @$employee->head()->name }}">
                        <input id="employee_head_id" type="hidden" name="head_id" value="{{ $employee->head_id }}">
                    </div>
                    <div class="form-group">
                        <label for="employee_employment_date">Date of employment</label>
                        <input id="employee_employment_date"
                               type="text" name="employment_date"
                               class="form-control"
                               autocomplete="off"
                               value="{{ $employee->getConvertedEmploymentDate() }}">
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-6">
                                <div>
                                    <strong>Created at:</strong>
                                    <span>{{ $employee->created_at ? $employee->created_at->format('d-m-Y') : '' }}</span>
                                </div>
                                <div>
                                    <strong>Updated at:</strong>
                                    <span>{{ $employee->updated_at ? $employee->updated_at->format('d-m-Y') : '' }}</span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div>
                                    <strong>Admin created id:</strong>
                                    <span>{{ $employee->admin_created_id }}</span>
                                </div>
                                <div>
                                    <strong>Admin updated id:</strong>
                                    <span>{{ $employee->admin_updated_id }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="box-footer">
                        <div class="pull-right">
                            <a href="{!! route('employees.list') !!}" class="btn btn-default btn-flat">Cancel</a>
                            <button type="submit" class="btn btn-success btn-flat">Save</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @if ($errors->any())
        <div class="alert alert-danger col-md-6">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
@stop

@push('js')
    <script>

        $(function () {
            $('#employee_head').autocomplete({
                source: "{!! route('employees.get_head') !!}",
                select: function (event, ui) {
                    $('#employee_head_id').val(ui.item.id); // save selected id to hidden input
                }
            });

            $('#employee_position').select2({
                width: '100%'
            });

            $('#employee_phone').inputmask({"mask": "+399(99)9999999"});
            $('#employee_employment_date').datepicker({
                format: 'mm.dd.yy',
            });
        });
    </script>
@endpush