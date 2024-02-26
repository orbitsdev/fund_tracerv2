<?php

use App\Livewire\ListMOOE;
use App\Livewire\TestPage;
use App\Livewire\Particular;
use App\Livewire\ViewProject;
use App\Livewire\LineItemBudget;
use App\Livewire\ListParticulars;
use App\Livewire\Users\ListUsers;
use App\Livewire\CreateManagement;
use App\Livewire\ContentManagement;
use Illuminate\Support\Facades\Auth;
use App\Livewire\PSGroup\EditPsGroup;
use Illuminate\Support\Facades\Route;
use App\Livewire\ListPersonalServices;
use App\Livewire\Programs\EditProgram;
use App\Livewire\Programs\ViewProgram;
use App\Livewire\Projects\EditProject;
use App\Livewire\ListImplentinAgencies;
use App\Livewire\Programs\ListPrograms;
use App\Livewire\ProjectLineItemBudget;
use App\Livewire\Projects\ListProjects;
use App\Livewire\ViewProjectYearBudget;
use App\Livewire\Programs\CreateProgram;
use App\Livewire\Projects\CreateProject;
use App\Livewire\MOOEGroup\EditMOOEGroup;
use App\Livewire\FinancialManagerDashboard;
use App\Livewire\MonitoringAgency\ListMonitoringAgencies;
use App\Livewire\FinancialManagerProjects\ListFinancialManager;
use App\Livewire\ForbiddenPage;

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

Route::get('/test-page', TestPage::class);
Route::get('/no-project-assigned.forbidden', ForbiddenPage::class)->name('financial-manager.forbidden');

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {

    Route::get('/dashboard', function () {

        if(Auth::user()->is_admin()){

            return redirect()->route('program.index');
        }else{
            return redirect()->route('financial-manager.dashboard');
        }
        // return view('dashboard');
    })->name('dashboard');

    Route::middleware(['no-project-assigned'])->prefix('financial-manager')->name('financial-manager.')->group(function(){
        Route::get('/dashbooard', FinancialManagerDashboard::class)->name('dashboard');
        Route::get('/projects', ListFinancialManager::class)->name('projects');
    });

    Route::middleware(['can:is-admin'])->group(function(){
        Route::prefix('manage')->name('manage.')->group(function(){
            Route::get('/user', ListUsers::class)->name('users');
            Route::get('/implementing-agencies', ListImplentinAgencies::class)->name('implementing-agencies');
            Route::get('/monitoring-agencies', ListMonitoringAgencies::class)->name('monitoring-agencies');
            Route::get('/program-project', CreateManagement::class)->name('program-project');
            Route::get('/content', ContentManagement::class)->name('content-management');
        }); //

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



});
