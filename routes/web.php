<?php

use App\Livewire\ListMOOE;
use App\Livewire\Particular;
use App\Livewire\ListParticulars;
use App\Livewire\CreateManagement;
use App\Livewire\ContentManagement;
use App\Livewire\LineItemBudget;
use App\Livewire\PSGroup\EditPsGroup;
use Illuminate\Support\Facades\Route;
use App\Livewire\ListPersonalServices;
use App\Livewire\Programs\EditProgram;
use App\Livewire\Programs\ViewProgram;
use App\Livewire\ListImplentinAgencies;
use App\Livewire\Programs\ListPrograms;
use App\Livewire\Programs\CreateProgram;
use App\Livewire\MOOEGroup\EditMOOEGroup;
use App\Livewire\MonitoringAgency\ListMonitoringAgencies;
use App\Livewire\ProjectLineItemBudget;
use App\Livewire\Projects\CreateProject;
use App\Livewire\Projects\EditProject;
use App\Livewire\Projects\ListProjects;
use App\Livewire\ViewProject;
use App\Livewire\ViewProjectYearBudget;

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

    Route::get('/dashboard', function () {
            return redirect()->route('program.index');
        // return view('dashboard');
    })->name('dashboard');
    Route::get('/content-management', ContentManagement::class)->name('content-management');
    Route::get('/implementing-agencies', ListImplentinAgencies::class)->name('implementing-agencies');
    Route::get('/monitoring-agencies', ListMonitoringAgencies::class)->name('monitoring-agencies');
    Route::get('/create-management', CreateManagement::class)->name('create-management');

    Route::prefix('program')->name('program.')->group(function(){
         Route::get('/', ListPrograms::class)->name('index');
         Route::get('/create', CreateProgram::class)->name('create');
         Route::get('/edit/{record}', EditProgram::class)->name('edit');
         Route::get('/view/{record}', ViewProgram::class)->name('view');
    });

    Route::prefix('project')->name('project.')->group(function(){
         Route::get('/', ListProjects::class)->name('index');
         Route::get('/create', CreateProject::class)->name('create');
         Route::get('/edit/{record}', EditProject::class)->name('edit');
         Route::get('/view/{record}', ViewProject::class)->name('view');
         Route::get('/line-item-budget/{record}', ProjectLineItemBudget::class)->name('line-item-budget');
         Route::get('/line-items/year/{record}', LineItemBudget::class)->name('line-items');
         Route::get('/line-items/year/{record}/view', ViewProjectYearBudget::class)->name('line-items-view');

    });

    Route::prefix('personal-service')->name('personal-service.')->group(function(){
         Route::get('/', ListPersonalServices::class)->name('index');
         Route::get('/edit/{record}', EditPsGroup::class)->name('edit');
    });
    Route::prefix('mooe')->name('mooe.')->group(function(){
         Route::get('/', ListMOOE::class)->name('index');
         Route::get('/edit/{record}', EditMOOEGroup::class)->name('edit');
    });


});
