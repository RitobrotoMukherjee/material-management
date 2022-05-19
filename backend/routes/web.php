<?php

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

Route::get('/', [App\Http\Controllers\Auth\AdminLoginController::class, 'showLoginForm'])->name('home');
Route::prefix('admin')->group(function () {
    Route::post('login', [App\Http\Controllers\Auth\AdminLoginController::class, 'login'])->name('admin.login');
    Route::middleware(['auth:web', 'admin'])->group(function () {
        Route::post('logout', [App\Http\Controllers\Auth\AdminLoginController::class, 'logout'])->name('admin.logout');
        Route::controller(UserController::class)->prefix('organization')->group(function () {
            Route::get('list', 'list')->name('org.list');
            Route::post('server-list', 'serverList')->name('org.server.list');
            Route::get('add-edit/{id?}', 'getDetailById')->name('org.add.edit');
            Route::post('save', 'upsert')->name('org.upsert');
        });
    });
});
