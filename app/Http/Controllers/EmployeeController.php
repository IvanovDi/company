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
            $mainEmployeeId = Employee::where('name', $arr_name[0])->where('last_name', $arr_name[1])->get()[0]->id;
        } else {
            $mainEmployeeId = null;
        }
        $employee =  Employee::create([
            'name' => $request->input('first_name'),
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
        $result['name'] = $item->name;
        $result['last_name'] = $item->last_name;
        $result['team_lead'] = $item->team_lead;
        $result['relation_id'] = $item->main_employee_id ?? 0;
        $result['group'] = $item->groups[0]->id ?? 0;

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

        $employees = Employee::with('relations', 'relationGroup', 'groups')->get();
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



    protected function getFullArray($employees)
    {
        $tmp_arr = [];
        $i = 0;
        foreach($employees as $employee) {
            if($employee instanceof Employee) {
                $tmp_arr[$i] = $this->getDataFromEmployee($employee);
            }
            if($employee instanceof Group) {
                $tmp_arr[$i] = $this->getDataFromGroup($employee);// todo проверить на работоспособность
            }
            if(!empty($employee->relations[0])) {
                $tmp_arr[$i]['relations'] = $this->getFullArray($employee->relations);
            }
             if(!empty($employee->relationGroup[0])) {
                $tmp_result = Group::where('id', $employee->id)->with('employees')->get();
                dd($tmp_result[0]);
                $tmp_arr[$i]['relationGroup'] = $this->getFullArray($employee->relationGroup);
                $tmp_arr[$i]['relationGroup']['groupsContent'] = $this->getFullArray($tmp_result[0]->relations);
             }
            $i++;
        }

          // dd($tmp_arr);
        return $tmp_arr;
    }



    public function show($id)
    {
        dd($this->getFullArray(Employee::with('relations', 'relationGroup', 'groups')->get()));
        return view('company.show', [
            //'relations' => $this->relation(),
            'relations' => $this->getFullArray(Employee::with('relations', 'relationGroup', 'groups')->get()
),
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
            $old = Employee::where('name', $arr_name[0])->where('last_name', $arr_name[1])->get()[0]->id;
        } else {
            $old = null;
        }

        $arr_name  = explode(' ', $request['new']);
        if($arr_name[0]) {
            $new = Employee::where('name', $arr_name[0])->where('last_name', $arr_name[1])->get()[0]->id;
        } else {
            $new= null;
        }

        Employee::destroy($old);
        Employee::where('main_employee_id', $old)->update(['main_employee_id' => $new]);
        Group::where('main_employee_id', $old)->update(['main_employee_id' => $new]);
        return redirect('employee');  
   }
}
