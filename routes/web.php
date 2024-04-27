<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});


Route::get('/countries', function () {
    return view('pages.countries');
})->name('countries');
