<?php

Route::get('/', function () {
    return redirect()->route('login');
    //return view('pages.dashboard');
});

/*
 * Auth routes
 * */

Route::group(['middleware' => 'guest', 'namespace' => 'Auth'], function () {
    Route::get('login', 'LoginController@showLoginForm');
    Route::post('login', 'LoginController@login')->name('login');

    Route::get('register', 'RegisterController@showRegistrationForm');
    Route::post('register', 'RegisterController@register')->name('register');
    Route::get('verify/{token}', 'RegisterController@verifyUser');
});
