<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\CuratorController;
use App\Http\Controllers\Admin\DocumentController;
use App\Http\Controllers\Admin\Exports\ExportController;
use App\Http\Controllers\Admin\Imports\ImportController;
use App\Http\Controllers\Admin\SemesterController;
use App\Http\Controllers\Admin\SettingsController;
use App\Http\Controllers\Admin\TableController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\IndexController;
use Illuminate\Support\Facades\Auth;
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


Route::group(['as' => 'lk.', 'middleware' => ['auth']], function () {
    Route::get('/', [IndexController::class, 'index'])->name('index');
    Route::get('/documents', [IndexController::class, 'documents'])->name('documents');
});


Route::group(['as' => 'admin.', 'middleware' => ['auth', 'dashboardAccess'], 'prefix' => 'dashboard'], function () {
    Route::get('/', [DashboardController::class, 'index'])->name('index');

    Route::group(['as' => 'semester.', 'prefix' => 'semesters', 'controller' => SemesterController::class], function() {
        Route::get('/', 'index')->name('list');
        Route::get('/create', 'create')->name('create');
        Route::post('/store', 'store')->name('store');
        Route::get('/edit/{semester}', 'edit')->name('edit');
        Route::post('/update', 'update')->name('update');
        Route::post('/destroy', 'destroy')->name('destroy');

        Route::get('/{semester}/tables', 'tables')->name('tables');

    });

    // Route::group(['as' => 'criteria.', 'prefix' => 'criterias', 'controller' => CriteriaController::class], function() {
    //     Route::get('/', 'index')->name('list');
    //     Route::get('/create', 'create')->name('create');
    //     Route::post('/store', 'store')->name('store');
    //     Route::get('/edit/{criteria}', 'edit')->name('edit');
    //     Route::post('/update', 'update')->name('update');
    //     Route::post('/destroy', 'destroy')->name('destroy');

    //     Route::get('/{criteria}/questions', 'questions')->name('questions');
    //     Route::get('/question/create/{criteria}', 'questionCreate')->name('question.create');
    //     Route::post('/question/store', 'questionStore')->name('question.store');
    //     Route::get('/question/edit/{criteriaQuestion}', 'questionEdit')->name('question.edit');
    //     Route::post('/question/update', 'questionUpdate')->name('question.update');
    //     Route::post('/question/destroy', 'questionDestroy')->name('question.destroy');

    //     Route::get('/{criteria}/users', 'users')->name('users');
    //     Route::get('/users/{user}', 'user')->name('user');
    // });


    Route::group(['as' => 'table.', 'prefix' => 'tables', 'controller' => TableController::class], function() {
        Route::get('/', 'index')->name('list');
        Route::get('/create', 'create')->name('create');
        Route::post('/store', 'store')->name('store');
        Route::get('/edit/{table}', 'edit')->name('edit');
        Route::post('/update', 'update')->name('update');
        Route::post('/destroy', 'destroy')->name('destroy');

        Route::get('/{table}/questions', 'questions')->name('questions');
        Route::get('/question/create/{table}', 'questionCreate')->name('question.create');
        Route::post('/question/store', 'questionStore')->name('question.store');
        Route::get('/question/edit/{tableQuestion}', 'questionEdit')->name('question.edit');
        Route::post('/question/update', 'questionUpdate')->name('question.update');
        Route::post('/question/destroy', 'questionDestroy')->name('question.destroy');

        Route::get('/{table}/users', 'users')->name('users');
        Route::get('/users/{user}', 'user')->name('user');
        
        Route::get('/{table}/users/add', 'addUsers')->name('users.add');
        Route::post('/{table}/users/destroy', 'destroyUser')->name('users.destroy');
    });


    Route::group(['as' => 'curator.', 'prefix' => 'curators', 'controller' => CuratorController::class], function() {
        Route::get('/', 'index')->name('list');
        Route::get('/create', 'create')->name('create');
        Route::post('/store', 'store')->name('store');
        Route::get('/edit/{curator}', 'edit')->name('edit');
        Route::post('/update', 'update')->name('update');
        Route::post('/destroy', 'destroy')->name('destroy');
    });

    Route::group(['as' => 'document.', 'prefix' => 'documents', 'controller' => DocumentController::class], function() {
        Route::get('/', 'index')->name('list');
        Route::get('/create', 'create')->name('create');
        Route::post('/store', 'store')->name('store');
        Route::get('/edit/{document}', 'edit')->name('edit');
        Route::post('/update', 'update')->name('update');
        Route::post('/destroy', 'destroy')->name('destroy');
    });

    Route::group(['as' => 'user.', 'prefix' => 'users', 'controller' => UserController::class], function() {
        Route::get('/', 'index')->name('list');
        Route::get('/create', 'create')->name('create');
        Route::post('/store', 'store')->name('store');
        Route::get('/edit/{user}', 'edit')->name('edit');
        Route::post('/update', 'update')->name('update');
        Route::post('/destroy', 'destroy')->name('destroy');
    });
    
    Route::group(['as' => 'settings.', 'prefix' => 'settings', 'controller' => SettingsController::class], function() {
        Route::get('/', 'index')->name('index');
        Route::post('/update', 'update')->name('update');
    });


    // EXPORT

    Route::get('users/export/', [ExportController::class, 'usersExport']);
    Route::get('oldusers/export/', [ExportController::class, 'oldUsersExport']);
    Route::get('table/{table}/export/', [ExportController::class, 'tableUsersExport'])->name('table.export');
    
    Route::get('users/import/', [ImportController::class, 'import']);
    
});


Auth::routes();