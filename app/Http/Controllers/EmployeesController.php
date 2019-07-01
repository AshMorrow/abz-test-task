<?php

namespace App\Http\Controllers;

use App\Employees;
use App\Position;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Intervention\Image\Facades\Image;
use Yajra\Datatables\Datatables;

class EmployeesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function show()
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
            'head_id',
        ]);

        return Datatables::of($employees)
            ->addColumn('action', function ($employee) {
                return '
                    <a href="'.route('employees.edit', $employee->id).'" class="btn btn-xs btn-primary btn-flat">
                        <i class="glyphicon glyphicon-edit"></i> Edit
                    </a>
                    <button 
                        class="btn btn-xs btn-danger btn-flat"
                        onclick="showDeletePopup(\''.route('employees.delete', $employee->id).'\', \''.addslashes($employee->name).'\')"                        
                    >
                        <i class="glyphicon glyphicon-trash"></i> Delete
                    </button>
                ';
            })
            ->make(true);
    }

    public function edit(Request $request, $id = null)
    {
        $employee = $id ? Employees::find($id) : new Employees();
        $positions = Position::all();

        if ($request->isMethod('post')){
            $attributes = $request->validate([
                'name' => 'required|max:255',
                'email' => 'required',
                'phone' => 'required',
                'salary' => 'required',
                'head_id' => 'numeric',
                'position_id' => 'required|numeric',
                'photo' => [
                    'image',
                    'max:5120',
                    'mimes:jpeg,png',
                    Rule::dimensions()->minWidth(300)->minHeight(300)
                ]
            ]);
            $uploaded_image = $request->file('photo');

            if ($uploaded_image) {
                $photo = Image::make($request->file('photo'));
                if ($photo->width() > 300 || $photo->height() > 300) {
                    $photo->resize(300, 300);
                }

                $photo->save('storage/'.$uploaded_image->hashName(), 80, 'jpg');
            }
            dd($photo);

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

    public function delete($id)
    {
        $newHead = Employees::inRandomOrder()->first();
        Employees::where('head_id', '=', $id)->update(['head_id' => $newHead->id]);
        Employees::find($id)->delete();
    }

    public function getHeadData(Request $request)
    {
        $heads = Employees::where('name', 'like', "%{$request->get('term')}%")
            ->select('id', 'name as label')
            ->take(10)
            ->get()
            ->toArray()
        ;

        return response()->json(
            $heads
        );
    }
}
