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

    public function showList()
    {
        $get_list_url = route('positions.data');
        return view('position.list',  ['get_list_url' => $get_list_url]);
    }

    public function getListData()
    {
        $positions = \App\Position::select([
            'id',
            'name'
        ]);

        return Datatables::of($positions)
            ->addColumn('action', function ($position) {
                return '
                    <a href="'.route('positions.edit', $position->id).'" class="btn btn-xs btn-primary btn-flat">
                        <i class="glyphicon glyphicon-edit"></i> Edit
                    </a>
                    <button 
                        class="btn btn-xs btn-danger btn-flat"
                        onclick="showDeletePopup(\''.route('employees.delete', $position->id).'\', \''.$position->name.'\')"                        
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
        }

        return view('position.edit', ['position' => $position]);
    }
}
