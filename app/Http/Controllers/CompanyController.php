<?php

namespace App\Http\Controllers;

use App\Models\{
    Employee,
    Group,
    Position
};
use Illuminate\Http\Request;

class CompanyController extends Controller
{
    public function index()
    {
        $positions = Position::pluck('name', 'id');
        $groups = Group::pluck('name', 'id');
        $employees = Employee::all(['id', 'name', 'last_name']);

        return view('company.index', [
            'positions' => $positions,
            'groups' => $groups,
            'employees' => $employees
        ]);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'position_id' => 'exists:positions,id',
            'main_employee_id' => 'exists:employees,id',
            'group_id' => 'exists:groups,id'
        ]);
        $team_lead = $request->has('team_lead');
        $mainEmployee = Employee::find($request->get('main_employee_id')); // todo move to validate method

        $employee = $mainEmployee->subordinates()->create([
            'name' => $request->input('first_name'),
            'last_name' => $request->input('last_name'),
            'team_lead' => $team_lead
        ]);

        $position = Position::find($request->get('position_id')); // todo move to validate method
        $employee->positions()->attach($position);

        $group = Group::find($request->get('group_id')); // todo move to validate method
        $employee->groups()->attach($group->id);



        return redirect()->back();
    }

    public function show()
    {
        \DB::enableQueryLog();
        $array = $this->getTreeUsers();
//        dd(\DB::getQueryLog());
        return view('company.show', [
            'data' => $array,
        ]);
    }

    protected function getTreeUsers($id = null)
    {

        //переписать все на массивы и удуалить fullname из модели после выполнения функции очистить статическую переменную
        $response = [];
        $users = $this->getEmployee($id);
        foreach ($users as $user) {
            $response[$user['id']]['name'] = $user['name'] . ' ' . $user['last_name'];
            foreach ($user['subordinates_groups'] as $group) {
                $employeeGroupArray = [];
                foreach ($group['employees'] as $employeeGroup) {
                    $employeeGroupArray[$employeeGroup['id']]['name'] = $employeeGroup['name'] . ' ' . $employeeGroup['last_name'];
                    dd($employeeGroup);
                    foreach ($employeeGroup['subordinates'] as $subordinate) {
                        $employeeGroupArray[$employeeGroup['id']]['child'] = $this->getTreeUsers($subordinate['id']);
                    }
                }
                //subordinates
                $response[$user['id']]['groups'][$group['id']] = [
                    'name' => $group['name'],
                    'employees' => $employeeGroupArray,
                ];
            }
            $response[$user['id']['child'] = $this->getTreeUsers($user['id'])];
        }
        return $response;
    }

    protected function getEmployee($id)
    {
        static $employeeUsed;
        if (!isset($employeeUsed[$id])) {
            $users = Employee::where('main_employee_id', $id)->with('subordinatesGroups.employees')->get()->toArray();
            //todo хранить только нужные данные
            $employeeUsed[$id] = $users;
        }
        return $employeeUsed[$id];
    }

    public function destroy(Request $request) //todo
    {
        $this->validate($request, [
            'id' => 'exists:employees,id',
        ]);

        $old = Employee::find($request->input('old'))->id;

        $new = Employee::find($request->input('new'))->id;
        Employee::destroy($old);
        Employee::where('main_employee_id', $old)->update(['main_employee_id' => $new]);
        Group::where('main_employee_id', $old)->update(['main_employee_id' => $new]);


        return redirect('employee');
    }
}
