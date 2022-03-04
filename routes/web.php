<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ChildrenController;
use App\Http\Controllers\PregnancyController;

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

Route::get('/', [HomeController::class, 'index'])->name('index');

Route::resource('users', UserController::class);

Route::get('/users/{user}/children/create', [
    ChildrenController::class,
    'create',
])->name('user.children.create');

Route::post('/users/{user}/children/store', [
    ChildrenController::class,
    'store',
])->name('user.children.store');

Route::put('/children/{children}', [ChildrenController::class, 'update'])->name(
    'user.children.update'
);

Route::get('/children/{children}', [ChildrenController::class, 'edit'])->name(
    'user.children.edit'
);

Route::delete('/users/{user}/children/{children}/destroy', [
    ChildrenController::class,
    'destroy',
])->name('user.children.destroy');

Route::get('/users/{user}/pregnancy/create', [
    PregnancyController::class,
    'create',
])->name('user.pregnancy.create');

Route::post('/users/{user}/pregnancy/store', [
    PregnancyController::class,
    'store',
])->name('user.pregnancy.store');

Route::put('/pregnancy/{pregnancy}', [
    PregnancyController::class,
    'update',
])->name('user.pregnancy.update');

Route::get('/pregnancy/{pregnancy}', [
    PregnancyController::class,
    'edit',
])->name('user.pregnancy.edit');

Route::delete('/users/{user}/pregnancy/{pregnancy}/destroy', [
    PregnancyController::class,
    'destroy',
])->name('user.pregnancy.destroy');
