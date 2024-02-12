<?php

use App\Livewire\ListParticulars;
use App\Livewire\Particular;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return redirect()->route('login');
    // return view('welcome');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {

    Route::get('/dashboard', function () { return view('dashboard');})->name('dashboard');

    Route::prefix('particulars')->name('particular.')->group(function(){
         Route::get('/', ListParticulars::class)->name('index');

    });


});
