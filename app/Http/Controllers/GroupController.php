<?php

namespace App\Http\Controllers;

use App\Models\{
    Employee,
    Group
};
use Illuminate\Http\Request;

class GroupController extends Controller
{

    public function store(Request $request)
    {
        $this->validate($request, [
            'id' => 'exists:employees,id',
        ]);
        $mainEmployeeId = Employee::find($request->input('main_employee_id'))->id;
        Group::create([
            'name' => $request['group_name'],
            'main_employee_id' => $mainEmployeeId
        ]);
        return redirect('employee');
    }

    public function show($id)
    {
        $res = Group::with('employees')->get();
        return view('company.group', ['data' => $res]);
    }


}
