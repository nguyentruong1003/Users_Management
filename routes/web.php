<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Auth::routes();
Route::get('/', function () {
    return view('auth.login');
});
Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::group(['middleware' => ['auth']], function () {

    Route::get('/lang/{lang}','App\Http\Controllers\LangController@changeLang')->name('lang');
    Route::group([
        'prefix' => 'master',
    ], function () {
        Route::get('/', 'App\Http\Controllers\Admin\Config\MasterController@index')->name('admin.config.master');
        Route::get('delete/{id}', 'App\Http\Controllers\Admin\Config\MasterController@delete')->name('admin.config.master.delete');
        Route::get('create', 'App\Http\Controllers\Admin\Config\MasterController@create')->name('admin.config.master.create');
        Route::get('edit/{id}', 'App\Http\Controllers\Admin\Config\MasterController@edit')->name('admin.config.master.edit');
        Route::post('insert', 'App\Http\Controllers\Admin\Config\MasterController@insert')->name('admin.config.master.insert');
        Route::post('update', 'App\Http\Controllers\Admin\Config\MasterController@update')->name('admin.config.master.update');
    });

    Route::group([
        'prefix' => 'system',
    ], function () {
        Route::get('/user', 'App\Http\Controllers\Admin\System\UserController@index')->name('admin.system.user.index');
        Route::get('/audit', 'App\Http\Controllers\Admin\System\AuditController@index')->name('admin.system.audit.list');
        Route::group([
            'prefix' => 'role',
        ], function () {
            Route::get('/', 'App\Http\Controllers\Admin\System\RoleController@index')->name('admin.system.role.index');
        });
    });

    Route::group([
        'prefix' => 'employee',
    ], function () {
        Route::get('/', 'App\Http\Controllers\Admin\EmployeeController@index')->name('admin.employee.index');
        Route::get('/create', 'App\Http\Controllers\Admin\EmployeeController@create')->name('admin.employee.create');
        Route::post('/store', 'App\Http\Controllers\Admin\EmployeeController@store')->name('admin.employee.store');
        Route::get('edit/{id}', 'App\Http\Controllers\Admin\EmployeeController@edit')->name('admin.employee.edit');
        Route::post('update/{id}', 'App\Http\Controllers\Admin\EmployeeController@update')->name('admin.employee.update');
        Route::get('/show/{id}', 'App\Http\Controllers\Admin\EmployeeController@show')->name('admin.employee.show');
    });

    Route::group([
        'prefix' => 'unit',
    ], function () {
        Route::get('/', 'App\Http\Controllers\Admin\UnitController@index')->name('admin.unit.index');
    });
});