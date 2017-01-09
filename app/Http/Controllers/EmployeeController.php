<?php

namespace App\Http\Controllers;

use App\Employee;
use App\Group;
use App\Position;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    public function index()
    {
        $position = Position::all();
        $group = Group::all();
        $relations = Employee::all();
        return view('company.index', [
            'positions' => $position,
            'groups' => $group,
            'relations' => $relations
        ]);
    }


    public function create(Request $request)
    {

    }


    public function store(Request $request)
    {
        $group_id = Group::where('name', $request['group'])->get();
        $group_id = $group_id[0]->id;
        $arr_name  = explode(' ', $request['relation']);
        if($arr_name[0]) {
            $relation = Employee::where('first_name', $arr_name[0])->where('last_name', $arr_name[1])->get()[0]->id;
        } else {
            $relation = null;
        }
        $employee =  Employee::create([
            'first_name' => $request->input('first_name'),
            'last_name' => $request->input('last_name'),
            'group_id' => $group_id,
            'relation' => $relation
         ]);
        $position = Position::where('name', $request['position'])->get();
        $employee->positions()->attach($position[0]->id);


        return redirect('employee');
    }

    protected function relation()
    {   $arr_relations = [];
        $res = Employee::with('relations')->get();
        foreach($res  as $item) {
            $name = $item->first_name;
            $tmp_arr = [];
            foreach($item->relations as $result) {
                $tmp_arr[] = $result->first_name;
            }
            $arr_relations[$name] = $tmp_arr;
        }
        return $arr_relations;
    }





    public function show($id)
    {
        $relation = $this->relation();
        $res = Employee::with('group', 'positions')->get();
        return view('company.show', ['data' => $res, 'relations' => $relation]);
    }


    public function edit($id)
    {
        //
    }


    public function update(Request $request, $id)
    {
        //
    }


    public function destroy($id)
    {
        //
    }
}
