<?php

Route::get('/', function () {
    return redirect()->route('login');
});

/*
 * Auth routes
 * */

Route::group([ 'middleware' => 'guest', 'namespace' => 'Auth' ], function () {
    Route::get('login/{email?}', 'LoginController@showLoginForm');
    Route::post('login', 'LoginController@login')->name('login');

    Route::get('register', 'RegisterController@showRegistrationForm');
    Route::post('register', 'RegisterController@register')->name('register');

    Route::get('verify/{token}', 'RegisterController@verifyUser')->name('account.verify');
    Route::get('resend/{email?}',
        'RegisterController@resendVerificationMail')->name('account.resend.verification.mail');
});

Route::group([ 'middleware' => 'auth' ], function () {
    Route::group([ 'prefix' => 'account', 'namespace' => 'Auth' ], function () {
        Route::get('logout', 'LoginController@logout')->name('logout');
        Route::get('password', 'PasswordController@edit')->name('account.password.edit');
        Route::post('password', 'PasswordController@update')->name('account.password.update');
    });

    Route::group([ 'prefix' => 'users', 'namespace' => 'Admin' ], function () {
        Route::get('/', 'UsersController@index')->name('users.index');
        Route::get('detail/{id?}', 'UsersController@detail')->name('users.detail');
        Route::get('synchronize/{id?}', 'UsersController@synchronize')->name('users.synchronize');
        Route::get('ban/{id}', 'UsersController@ban')->name('users.ban');
        Route::get('remove-ban/{id}', 'UsersController@removeBan')->name('users.remove.ban');
    });

    Route::group([ 'prefix' => 'subjects' ], function () {
        Route::group([ 'namespace' => 'Admin', 'middleware' => 'admin' ], function () {
            Route::get('/', 'SubjectsController@index')->name('admin.subjects.index');
            Route::get('/enable/{id}', 'SubjectsController@enable')->name('admin.subjects.enable');
            Route::get('/disable/{id}', 'SubjectsController@disable')->name('admin.subjects.disable');
        });

        Route::post('{subject_id}/store',
            'FolderController@store')->name('subjects.folder.store')->middleware('subject');

        Route::get('{subject_id}/{folder?}', 'FolderController@index')->name('subjects.folder')->middleware('admin');
    });

    Route::group([ 'prefix' => 'folders' ], function () {
        Route::get('{folder}/destroy', 'FolderController@destroy')->name('folders.destroy');
    });

    Route::group([ 'prefix' => 'files' ], function () {
        Route::get('{file}/download', 'FileController@download')->name('files.download');
        Route::get('{file}/destroy', 'FileController@destroy')->name('files.destroy');
        Route::post('upload', 'FileController@upload')->name('files.upload');
    });

    Route::group(['prefix' => 'colleagues'], function () {
        Route::get('/', 'ColleagueController@index')->name('colleagues.index');
        Route::get('{id}', 'ColleagueController@detail')->name('colleagues.detail');
    });

    Route::group(['prefix' => 'courses'], function () {
        Route::get('{subject_id}/{folder?}', 'FolderController@index')->name('courses.folder')->where('subject_id', '[0-9]+');
        Route::get('{all?}', 'CourseController@index')->name('courses.index');
    });

    Route::get('/', 'DashboardController@index')->name('dashboard');//->middleware(['cache.before', 'cache.after:1']);
});
