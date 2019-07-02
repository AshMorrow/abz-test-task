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
            'id',
            'name',
            'phone',
            'email',
            'photo',
            'salary',
            'position_id',
            'head_id',
        ]);

        return Datatables::of($employees)
            ->addColumn('photo', function ($employee) {
                return '<img src="'.asset('storage/'.$employee->photo).'" alt="" width="70" height="70" />';
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
                'salary' => 'required',
                'head_id' => 'exists:employees,id',
                'position_id' => 'exists:position,id',
                /*
                 *  Why it dose`nt work ?
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

                $photo_name = $uploaded_photo->hashName();
                $photo->encode('jpg', 80);

                Storage::disk('public')->put($photo_name, $photo);
                Storage::disk('public')->delete($employee->photo);

                $employee->photo = $photo_name;
            }

            $admin_user = $request->user()->id;
            $employee->fill($attributes);
            $employee->employment_date = date("Y-m-d", strtotime($request->post('employment_date')));
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
