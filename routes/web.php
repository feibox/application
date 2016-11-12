<?php

Route::get('/', function () {
    return redirect()->route('login');
});

/*
 * Auth routes
 * */

Route::group(['middleware' => 'guest', 'namespace' => 'Auth'], function () {
    Route::get('login', 'LoginController@showLoginForm');
    Route::post('login', 'LoginController@login')->name('login');

    Route::get('register', 'RegisterController@showRegistrationForm');
    Route::post('register', 'RegisterController@register')->name('register');

    Route::get('verify/{token}', 'RegisterController@verifyUser')->name('account.verify');
    Route::get('resend/{email}', 'RegisterController@resendVerificationEmail')->name('account.resend.verification.email');
});

Route::group(['middleware' => 'auth'], function () {
    Route::group(['prefix' => 'account','namespace' => 'Auth'], function () {
        Route::get('logout', 'LoginController@logout')->name('logout');
        Route::get('password', 'PasswordController@edit')->name('account.password.edit');
        Route::post('password', 'PasswordController@update')->name('account.password.update');
    });

    Route::group(['prefix' => 'users', 'namespace' => 'admin'], function () {
        Route::get('/', 'UsersController@index')->name('users.index');
        Route::get('synchronize/{email}', 'UsersController@synchronize')->name('users.synchronize');

        Route::group(['middleware' => 'admin'], function () {
            //Route::get('users', 'UsersController@index');
        });
    });





    Route::get('/', 'DashboardController@index')->name('dashboard');
});
