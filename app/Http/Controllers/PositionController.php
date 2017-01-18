<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Position;

class PositionController extends Controller
{

    public function store(Request $request)
    {
        Position::create([
            'name' => $request['position_name']
        ]);

        return redirect('employee');
    }

}