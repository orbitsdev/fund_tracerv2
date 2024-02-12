<?php

use App\Livewire\Particular;
use App\Livewire\ListParticulars;
use App\Livewire\PSGroup\EditPsGroup;
use Illuminate\Support\Facades\Route;
use App\Livewire\ListPersonalServices;

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

    Route::prefix('personal-service')->name('personal-service.')->group(function(){
         Route::get('/', ListPersonalServices::class)->name('index');
         Route::get('/edit/{record}', EditPsGroup::class)->name('edit');

    });


});
