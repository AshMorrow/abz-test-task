<?php

namespace App\Http\Controllers;

use App\Employees;
use App\Position;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
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
            'employees.id',
            'employees.name',
            'employees.phone',
            'employees.email',
            'employees.photo',
            'employees.salary',
            \DB::raw('DATE_FORMAT(employees.employment_date, "%d.%m.%y") as employment_date'),
            \DB::raw('position.name as position_name'),
        ])->join('position', 'employees.position_id', '=', 'position.id');

        return Datatables::of($employees)
            ->addColumn('photo', function ($employee) {
                $image_path = Storage::disk('public')->has($employee->photo) ? 'storage/'.$employee->photo : 'image/avatar-default.jpg';
                return '<img src="'.asset($image_path).'" alt="user avatar" width="70" height="70" />';
            })
            ->addColumn('salary', function ($employee) {
                return '$'. $employee->salary;
            })
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
            ->rawColumns(['photo', 'action'])
            ->make(true);
    }

    public function edit(Request $request, $id = null)
    {
        $employee = $id ? Employees::find($id) : new Employees();
        $positions = Position::all();

        if ($request->isMethod('post')){

            $attributes = $request->validate([
                'name' => 'required|max:255',
                'email' => 'required|email',
                'phone' => 'required|regex:/(\+3[0-9]{2})(\([0-9]{2}\))[0-9]{7}/',
                'salary' => 'required|numeric|between:0,500.000',
                'head_id' => 'nullable|exists:employees,id',
                'position_id' => 'exists:position,id',
                /*
                 *  Why it doesn't work ?
                 * 'employment_date' => 'required|date_format:"d-m-y"'
                */
                'employment_date' => 'required',
                'photo' => [
                    'image',
                    'max:5120',
                    'mimes:jpeg,png',
                    Rule::dimensions()->minWidth(300)->minHeight(300)
                ]
            ]);

            $uploaded_photo = $request->file('photo');

            if ($uploaded_photo) {
                $photo = Image::make($request->file('photo'));

                if ($photo->width() > 300 || $photo->height() > 300) {
                    $photo->resize(300, 300);
                }

                $photo_name = uniqid().'.jpg';
                $photo->save('storage/'.$photo_name, 80, 'jpg');

                Storage::disk('public')->delete($employee->photo);

                $employee->photo = $photo_name;
            }

            $employee->fill($attributes);
            $employee->employment_date = date("Y-m-d", strtotime($request->post('employment_date')));
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
