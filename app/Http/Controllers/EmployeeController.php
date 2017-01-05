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
        //
    }


    public function create(Request $request)
    {

    }


    public function store(Request $request)
    {
        $group_id = Group::all()->where('name', $request['group']);
        $group_id = $group_id[1]->id;


        $employee =  Employee::create([
            'first_name' => $request->input('first_name'),
            'last_name' => $request->input('last_name'),
            'group_id' => $group_id,
        ]);
        $employee->positions()->attach(2);


        return redirect('/view');
    }


    public function show($id)
    {
        $res = Employee::all();
        dd($res);
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
