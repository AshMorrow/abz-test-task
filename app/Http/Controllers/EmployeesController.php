<?php

namespace App\Http\Controllers;

use App\Employees;
use App\Position;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;

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
            ->addColumn('action', function ($employee) {
                return '
                    <a href="'.route('employees.edit', $employee->id).'" class="btn btn-xs btn-primary btn-flat">
                        <i class="glyphicon glyphicon-edit"></i> Edit
                    </a>
                    <button 
                        class="btn btn-xs btn-danger btn-flat"
                        onclick="showDeletePopup(\''.route('employees.delete', $employee->id).'\', \''.$employee->name.'\')"                        
                    >
                        <i class="glyphicon glyphicon-trash"></i> Delete
                    </button>
                ';
            })
            ->make(true);
    }

    public function edit(Request $request, $id = null){
        $employee = $id ? Employees::find($id) : new Employees();
        $positions = Position::all();

        if ($request->isMethod('post')){
            $attributes = $request->validate([
                'name' => 'required|max:255',
                'email' => 'required',
                'phone' => 'required',
                'salary' => 'required',
                'position_id' => 'required|numeric'
            ]);

            $admin_user = $request->user()->id;
            $employee->fill($attributes);
            $employee->admin_updated_id = $admin_user;
            $employee->admin_created_id = $admin_user;
            $employee->save();

            return redirect()
                ->route('employees.edit', ['id' => $employee->id])
                ->with('status', 'Profile updated!')
            ;
        }

        return view('employees.edit', [
            'employee' => $employee,
            'positions' => $positions
        ]);
    }

    public function delete($id) {
        Employees::find($id)->delete();
    }
}
