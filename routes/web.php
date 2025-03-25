<?php

use App\Http\Controllers\Spatielook;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SpatielookController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/spatielook',[Spatielook::class, 'index'])->name('spatielook.index');
Route::post('/roles', [Spatielook::class, 'storeRole'])->name('roles.store');
Route::post('/permissions', [Spatielook::class, 'storePermission'])->name('permissions.store');
Route::post('/assign-permission', [Spatielook::class, 'assignPermission'])->name('permissions.assign');
Route::delete('/roles/{id}', [Spatielook::class, 'destroyRole'])->name('roles.destroy');
Route::delete('/permissions/{id}', [Spatielook::class, 'destroyPermission'])->name('permissions.destroy');
Route::put('/roles/{id}', [Spatielook::class, 'updateRole'])->name('roles.update');
Route::put('/permissions/{id}', [Spatielook::class, 'updatePermission'])->name('permissions.update');