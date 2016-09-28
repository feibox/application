<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

Route::get('hoco/{id}', function()
{
	return "hello";
});

Route::get('files/{path}', array('as' => 'files', 'uses' => 'DataStructures@getStructure'));
Route::get('project/{path}', array('as' => 'files', 'uses' => 'DataStructures@openFile'));
Route::get('stu', array('as'=>'stu', 'uses'=>'DataStructures@getStu'));
Route::get('serus/{path}', array('as'=>'files', 'uses'=>'DataStructures@getSerus'));
