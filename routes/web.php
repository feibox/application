<?php

Route::get('error/{num}', function ($num) {
    abort($num);
});

Route::get('/', function () {
    return redirect()->route('login');
});

/*
 * Auth routes
 * */

Route::group(['middleware' => 'guest', 'namespace' => 'Auth'], function () {
    Route::get('login/{email?}', 'LoginController@showLoginForm');
    Route::post('login', 'LoginController@login')->name('login');

    Route::get('register', 'RegisterController@showRegistrationForm');
    Route::post('register', 'RegisterController@register')->name('register');

    Route::get('verify/{token}', 'RegisterController@verifyUser')->name('account.verify');
    Route::get('resend/{email?}',
        'RegisterController@resendVerificationMail')->name('account.resend.verification.mail');
});

Route::group(['middleware' => 'auth'], function () {
    Route::group(['prefix' => 'account', 'namespace' => 'Auth'], function () {
        Route::get('logout', 'LoginController@logout')->name('logout');
        Route::get('password', 'PasswordController@edit')->name('account.password.edit');
        Route::post('password', 'PasswordController@update')->name('account.password.update');
    });

    Route::group(['prefix' => 'users', 'namespace' => 'Admin'], function () {
        Route::get('/', 'UsersController@index')->name('users.index');
        Route::get('detail/{id?}', 'UsersController@detail')->name('users.detail');
        Route::get('synchronize/{id?}', 'UsersController@synchronize')->name('users.synchronize');
        Route::get('ban/{id}', 'UsersController@ban')->name('users.ban');
        Route::get('remove-ban/{id}', 'UsersController@removeBan')->name('users.remove.ban');
        Route::group(['middleware' => 'admin'], function () {
            //Route::get('users', 'UsersController@index');
        });
    });

    Route::group(['prefix' => 'subjects'], function () {
        Route::group(['namespace' => 'Admin'], function () {
            Route::get('/', 'SubjectsController@index')->name('subjects.index');
            Route::get('/enable/{id}', 'SubjectsController@enable')->name('subjects.enable');
            Route::get('/disable/{id}', 'SubjectsController@disable')->name('subjects.disable');
        });

        Route::group(['prefix' => '{subject_id}/folder', 'middleware' => 'subject'], function () {
            Route::get('/create', 'FolderController@create')->name('subject.folder.create');
            Route::post('/store', 'FolderController@store')->name('subject.folder.store');
        });

        Route::group(['prefix' => '{subject_id}/{folder?}', 'middleware' => 'subject'], function () {
            Route::get('/', 'FolderController@index')->name('subject.folder');
            Route::get('/create', 'FolderController@create')->name('subject.folder.specific.create');
            Route::post('/store', 'FolderController@store')->name('subject.folder.specific.store');
        });


    });

    Route::get('/', 'DashboardController@index')->name('dashboard');
});
