<?php

namespace App\Http\Controllers;

use App\Position;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;

class PositionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function show()
    {
        return view('position.list');
    }

    public function getListData()
    {
        $positions = \App\Position::select([
            'id',
            'name',
            \DB::raw('DATE_FORMAT(updated_at, "%d.%m.%y") as last_update')
        ]);

        return Datatables::of($positions)
            ->addColumn('action', function ($position) {
                return '
                    <a href="'.route('positions.edit', $position->id).'" class="btn btn-xs btn-primary btn-flat">
                        <i class="glyphicon glyphicon-edit"></i> Edit
                    </a>
                    <button 
                        class="btn btn-xs btn-danger btn-flat"
                        onclick="showDeletePopup(\''.route('positions.delete', $position->id).'\', \''.$position->name.'\')"                        
                    >
                        <i class="glyphicon glyphicon-trash"></i> Delete
                    </button>
                ';
            })
            ->make(true);
    }

    public function edit(Request $request, $id = null){
        $position = $id ? Position::find($id) : new Position();

        if ($request->isMethod('post')){
            $attributes = $request->validate([
                'name' => 'required|max:255'
            ]);

            $position->fill($attributes)->save();
            return redirect()
                ->route('positions.edit', ['id' => $position->id])
                ->with('status', 'Profile updated!')
            ;
        }

        return view('position.edit', ['position' => $position]);
    }

    public function delete($id) {
        Position::find($id)->delete();
    }
}
