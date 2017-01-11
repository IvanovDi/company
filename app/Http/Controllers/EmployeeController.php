<?php

namespace App\Http\Controllers;

use App\Employee;
use App\Group;
use App\Position;
use Illuminate\Http\Request;
use phpDocumentor\Reflection\Types\Array_;

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

//todo
//    public function create(Request $request)
//    {
//
//    }


    public function store(Request $request)
    {
        $team_lead = $request->input('team_lead') ? true : false;
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
            'relation' => $relation,
            'team_lead' => $team_lead
         ]);
        $position = Position::where('name', $request['position'])->get();
        $employee->positions()->attach($position[0]->id);


        return redirect('employee');
    }

    protected function relation()
    {   $arr_relations = [];
        $res = Employee::with('relations', 'relationGroup')->get();
        foreach($res  as $item) {
            $name = $item->first_name;
            $tmp_group_arr = [];
            if($item->relationGroup) {
                $group = $item->relationGroup;
                foreach($group as $items) {
                    $tmp_group_arr[$items->name] = $items->with('employees')->where('name', $items->name)->get();
                }
            }
            $tmp_arr = [];
            foreach($item->relations as $result) {

                $tmp_arr[$result->first_name] = $result;
            }
            $arr_relations[$name] = array_merge($tmp_arr, $tmp_group_arr);
        }
//        dd($arr_relations);
        return $arr_relations;
    }



    public function show($id)
    {
        $relation = $this->relation();
        $res = Employee::with('group', 'positions')->get();
        $groups = Group::with('employees')->get();
        return view('company.show', [
            'data' => $res,
            'relations' => $relation,
            'groups' => $groups
        ]);
    }

//todo
//    public function edit($id)
//    {
//        //
//    }
//
//
//    public function update(Request $request, $id)
//    {
//        //
//    }
//
//
//    public function destroy($id)
//    {
//        //
//    }
}
