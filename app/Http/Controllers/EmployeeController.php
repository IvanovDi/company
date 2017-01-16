<?php

namespace App\Http\Controllers;

use App\Employee;
use App\Group;
use App\Position;
use Illuminate\Http\Request;
use phpDocumentor\Reflection\Types\Array_;

class EmployeeController extends Controller
{


    protected $arr_employee = [];

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

    protected function getDataFromEmployee($item)
    {
        $result = [];
        $result['id'] = $item->id;
        $result['name'] = $item->first_name;
        $result['last_name'] = $item->last_name;
        $result['team_lead'] = $item->team_lead;
        $result['relation_id'] = $item->relation ?? 0;
        $result['group'] = $item->group->id ?? 0;

        return $result;
    }

    protected function getDataFromGroup($item)
    {
        $result = [];
        $result['id'] = $item->id;
        $result['name'] = $item->name;
        $result['relation_id'] = $item->relation ?? 0;
        $result['isgroup'] = 'group';

        return $result;
    }

    protected function getArrayGroup()
    {
        $groups = Group::with('employees')->get();
        $result = [];
        foreach($groups as $group) {
            $tmp_arr = [];
            foreach($group->employees as $employee) {
                $tmp_arr = $this->getDataFromEmployee($employee);
                $result[$group->id][] = $tmp_arr;
            }
        }
        return $result;
    }


    protected function relation()
    {
        $tmp_arr = [];

        $employees = Employee::with('relations', 'relationGroup')->get();
        $groups = Group::with('relations')->get();
        foreach($employees as $employee) {
            $tmp_arr[$employee->relation ?? 0][] = $this->getDataFromEmployee($employee);
        }
        foreach($groups as $group) {
            $tmp_arr[$group->relation ?? 0][] = $this->getDataFromGroup($group);
        }
        // dd($tmp_arr);
        return $tmp_arr;
    }



    public function show($id)
    {
        return view('company.show', [
            'relations' => $this->relation(),
            'groupsContent' => $this->getArrayGroup()
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
   public function destroy($id, Request $request)
   {
        $arr_name  = explode(' ', $request['old']);
        if($arr_name[0]) {
            $old = Employee::where('first_name', $arr_name[0])->where('last_name', $arr_name[1])->get()[0]->id;
        } else {
            $old = null;
        }

        $arr_name  = explode(' ', $request['new']);
        if($arr_name[0]) {
            $new = Employee::where('first_name', $arr_name[0])->where('last_name', $arr_name[1])->get()[0]->id;
        } else {
            $new= null;
        }


        Employee::destroy();
        Employee::where('relation', $old)->update(['relation' => $new]);
        Group::where('relation', $old)->update(['relation' => $new]);
        return redirect('employee');  
   }
}
