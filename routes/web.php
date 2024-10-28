<?php

use App\Livewire\Test;
use Illuminate\Support\Facades\Route;

//Route::get('/', function () {
//    return view('welcome');
//});

Route::redirect('/', '/parent');

Route::get('/test', Test::class);

