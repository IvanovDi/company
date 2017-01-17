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
        $arr_name  = explode(' ', $request['main_employee_id']);
        if($arr_name[0]) {
            $mainEmployeeId = Employee::where('first_name', $arr_name[0])->where('last_name', $arr_name[1])->get()[0]->id;
        } else {
            $mainEmployeeId = null;
        }
        $employee =  Employee::create([
            'first_name' => $request->input('first_name'),
            'last_name' => $request->input('last_name'),
            'main_employee_id' => $mainEmployeeId,
            'team_lead' => $team_lead
         ]);
        if($request['position']) {
            $position = Position::where('name', $request['position'])->get();
            $employee->positions()->attach($position[0]->id);
        }
        if($request['group']) {
            $group_id = Group::where('name', $request['group'])->get();
            $employee->groups()->attach($group_id[0]->id);
        }


        return redirect('employee');
    }

    protected function getDataFromEmployee($item)
    {
        $result = [];
        $result['id'] = $item->id;
        $result['name'] = $item->first_name;
        $result['last_name'] = $item->last_name;
        $result['team_lead'] = $item->team_lead;
        $result['relation_id'] = $item->main_employee_id ?? 0;
        $result['group'] = $item->group->id ?? 0;

        return $result;
    }

    protected function getDataFromGroup($item)
    {
        $result = [];
        $result['id'] = $item->id;
        $result['name'] = $item->name;
        $result['relation_id'] = $item->main_employee_id ?? 0;
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
            $tmp_arr[$employee->main_employee_id ?? 0][] = $this->getDataFromEmployee($employee);
        }
        foreach($groups as $group) {
            $tmp_arr[$group->main_employee_id ?? 0][] = $this->getDataFromGroup($group);
        }
//         dd($tmp_arr);
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

        Employee::destroy($old);
        Employee::where('main_employee_id', $old)->update(['main_employee_id' => $new]);
        Group::where('main_employee_id', $old)->update(['main_employee_id' => $new]);
        return redirect('employee');  
   }
}
