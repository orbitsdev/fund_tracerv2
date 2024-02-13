<?php

use App\Livewire\ContentManagement;
use App\Livewire\ListMOOE;
use App\Livewire\Particular;
use App\Livewire\ListParticulars;
use App\Livewire\PSGroup\EditPsGroup;
use Illuminate\Support\Facades\Route;
use App\Livewire\ListPersonalServices;
use App\Livewire\MOOEGroup\EditMOOEGroup;

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
    Route::get('/content-management', ContentManagement::class)->name('content-management');

    Route::prefix('personal-service')->name('personal-service.')->group(function(){
         Route::get('/', ListPersonalServices::class)->name('index');
         Route::get('/edit/{record}', EditPsGroup::class)->name('edit');
    });
    Route::prefix('mooe')->name('mooe.')->group(function(){
         Route::get('/', ListMOOE::class)->name('index');
         Route::get('/edit/{record}', EditMOOEGroup::class)->name('edit');
    });


});
