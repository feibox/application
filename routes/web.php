<?php

Route::get('/', function () {
    return view('pages.dashboard');
});

Route::get('login', function () {
    return view('pages.login');
})->name('login');