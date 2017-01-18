<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

Route::resource('employee', 'CompanyController', [
    'except' => [
        'destroy', 'edit', 'update', 'create', 'show'
    ],
    'names' => [
        'index' => 'employee.index',
        'show' => 'employee.show',
        'store' => 'employee.store'
    ]
]);

Route::delete('destroy', [
    'as' => 'employee.destroy',
    'uses' => 'CompanyController@destroy'
]);

Route::get('show', [
    'as' => 'employee.show',
    'uses' => 'CompanyController@show'
]);

Route::resource('position', 'PositionController', [
    'only' => [
        'store',
    ],
    'names' => [
        'store' => 'position.store'
    ]
]);

Route::resource('group', 'GroupController', [
    'only' => [
        'store', 'show'
    ],
    'names' => [
        'show' => 'group.show',
        'store' => 'group.store'
    ]
]);