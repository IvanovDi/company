<?php

namespace App\Http\Controllers;

use App\Models\{
    Employee,
    Group,
    Position
};
use App\User;
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
        $array = $this->getTreeUsers();
        return view('company.show', [
            'data' => $array,
        ]);
    }

    protected function getTreeUsers($id = null)
    {
        $response = [];
        $users = Employee::where('main_employee_id', $id)->get();
        foreach ($users as $user) {
            $response[$user->id]['name'] = $user->getFullName();
            $groups = $user->subordinatesGroups()->with('employees')->get();
            foreach ($groups as $group) {
                $employeeGroupArray = [];
                foreach ($group->employees as $employeeGroup) {
                    $employeeGroupArray[$employeeGroup->id]['name'] = $employeeGroup->getFullName();
                    foreach ($employeeGroup->subordinates as $subordinate) {
                        $employeeGroupArray[$employeeGroup->id]['child'] = $this->getTreeUsers($subordinate->id);
                    }
                }
                //subordinates
                $response[$user->id]['groups'][$group->id] = [
                    'name' => $group->name,
                    'employees' => $employeeGroupArray,
                ];
            }
            $response[$user->id]['child'] = $this->getTreeUsers($user->id);
        }
        return $response;
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
