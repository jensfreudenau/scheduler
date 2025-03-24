<?php

use App\Http\Controllers\Admin\ColorController;
use App\Http\Controllers\Admin\EventsController;
use App\Http\Controllers\Admin\GroupController;
use App\Http\Controllers\Admin\HomeController;
use App\Http\Controllers\Admin\PermissionsController;
use App\Http\Controllers\Admin\RolesController;
use App\Http\Controllers\Admin\UsersController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Log;

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

Route::get('/', function () {
    return redirect()->route('login');
});

Auth::routes();


Route::get('/home', [App\Http\Controllers\Admin\EventsController::class, 'index'])->name('home');

Route::group(['middleware' => ['auth'], 'prefix' => 'admin', 'as' => 'admin.'], function () {
    Route::post('/events/{search}', [EventsController::class, 'search'])->name('events.search');
    Route::get('/events/list', [EventsController::class, 'list'])->name('events.list');
    Route::get('/events/index', [EventsController::class, 'index'])->name('events.index');
    Route::delete('/events/delete', [EventsController::class, 'destroy'])->name('events.delete');
    Route::get('/users/scheduler/{user_id}', [UsersController::class, 'scheduler'])->name('users.scheduler');
    Route::resource('/', HomeController::class);
    Route::resource('/roles', RolesController::class);
    Route::resource('/users', UsersController::class);
    Route::resource('/events', EventsController::class);
    Route::resource('/permissions', PermissionsController::class);
    Route::resource('/groups', GroupController::class);
    Route::resource('/colors', ColorController::class);
    Route::resource('/api/eventdata', App\Http\Controllers\Admin\Api\EventDataController::class);


    Route::post('events_mass_destroy', ['uses' => 'Admin\EventsController@massDestroy', 'as' => 'events.mass_destroy']);
});
Route::get('/logout', '\App\Http\Controllers\Auth\LoginController@logout');

