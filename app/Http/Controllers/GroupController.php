<?php

namespace App\Http\Controllers;


use App\Employee;
use App\Group;
use Illuminate\Http\Request;

class GroupController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
//todo
//    public function index()
//    {
//        //
//    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
//todo
//    public function create()
//    {
//        //
//    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $arr_name = explode(' ', $request['relation']);
        if ($arr_name[0] && $arr_name[0] !== 'null') {
            $relation = Employee::where('name', $arr_name[0])->where('last_name', $arr_name[1])->get()[0]->id;
        } else {
            $relation = null;
        }

        Group::create([
            'name' => $request['group_name'],
            'main_employee_id' => $relation
        ]);
        return redirect('employee');
    }

    protected function getArrayGroup($group)
    {

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
//        $relations = Employee::with('employees')->get();
        $res = Group::with('employees')->get();
        return view('company.group', ['data' => $res]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
//todo
//    public function edit($id)
//    {
//        //
//    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
//todo
//    public function update(Request $request, $id)
//    {
//        //
//    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
//todo
//    public function destroy($id)
//    {
//        //
//    }
}
