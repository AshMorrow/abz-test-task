<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use App\Employees;

class EmployeesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function showList()
    {
        return view('employees.list');
    }

    public function edit($id){
        $employess = Employees::find($id) ?? new Employees();
        return view('employees.edit', compact($employess));
    }

    public function getListData()
    {
        $employees = \App\Employees::select([
            'id',
            'name',
            'phone',
            'email',
            'salary',
            'position_id',
            'head_id'
        ]);

        return Datatables::of($employees)
            ->addColumn('action', function ($employees) {
                return '
                    <a href="'.route('employees.edit', $employees->id).'" class="btn btn-xs btn-primary"><i class="glyphicon glyphicon-edit"></i> Edit</a>
                    <a href="#edit-'.$employees->id.'" class="btn btn-xs btn-danger"><i class="glyphicon glyphicon-trash"></i> Delete</a>
                ';
            })
            ->make(true);
    }
}
