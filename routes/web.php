<?php

Route::get('/', function() {
    return view('pages.dashboard');
});

/*
 * Auth routes
 * */

Route::group(['middleware' => 'guest', 'namespace' => 'Auth'], function () {
    Route::get('login', 'LoginController@showLoginForm');
    Route::post('login', 'LoginController@login')->name('login');

    Route::get('register', 'RegisterController@showRegistrationForm');
    Route::post('register', 'RegisterController@register');
});