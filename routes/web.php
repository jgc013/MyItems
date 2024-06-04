<?php

use App\Http\Controllers\LogisticsCentersController;
use App\Http\Controllers\LogisticsCenterXController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\ItemsController;
use App\Http\Controllers\MovementController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    Auth::logout();
    return view('auth/login');
});

Route::get('/dashboard.admin', [ItemsController::class, 'listDashboard'])->middleware(['auth', 'verified','admin'])->name('dashboard.admin');

Route::get('/movement.list', [MovementController::class, 'list']
)->middleware(['auth', 'verified','employee'])->name('movement.list');

Route::post('/movement.create', [MovementController::class, 'store'])->middleware(['auth', 'verified','employee'])->name('movement.create');
Route::get('/movement.delete/{id}', [MovementController::class, 'delete'])->middleware(['auth', 'verified','employee'])->name('movement.delete');
Route::get('/movements.logisticsCenter/{logisticsCenter}', [MovementController::class, 'list'])->middleware(['auth', 'verified','admin'])->name('movements.logisticsCenter');






Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});




Route::get('/logisticsCenters', [LogisticsCentersController::class, 'list'])->middleware(['auth', 'verified','admin'])->name('logisticsCenters.list');
Route::post('/logisticsCenters', [LogisticsCentersController::class, 'store'])->middleware(['auth', 'verified','admin'])->name('logisticsCenters.create');
Route::get('/logisticsCenters/{id}', [LogisticsCentersController::class, 'destroy'])->middleware(['auth', 'verified','admin'])->name('logisticsCenters.delete');
Route::post('/logisticsCenters/{id}', [LogisticsCentersController::class, 'edit'])->middleware(['auth', 'verified','admin'])->name('logisticsCenters.edit');


Route::get('/logisticsCenterXreports/{logisticsCenter}', [LogisticsCenterXController::class, 'reports'])->middleware(['auth', 'verified','admin'])->name('logisticsCenterX.reports');
Route::post('/logisticsCenterX.newReport', [LogisticsCenterXController::class, 'createReport'])->middleware(['auth', 'verified','admin'])->name('logisticsCenterX.newReport');

Route::get('/logisticsCenterXstaff/{logisticsCenter}', [LogisticsCenterXController::class, 'init'])->middleware(['auth', 'verified','admin'])->name('logisticsCenterX.init');
Route::post('/logisticsCenterXstaff', [RegisteredUserController::class, 'storeUser'])->middleware(['auth', 'verified','admin'])->name('user.new');
Route::get('/logisticsCenterXstaff', [RegisteredUserController::class, 'delete'])->middleware(['auth', 'verified','admin'])->name('user.delete');
Route::post('/logisticsCenterXstaff/{id}', [RegisteredUserController::class, 'edit'])->middleware(['auth', 'verified','admin'])->name('user.edit');


Route::get('/locate', [ItemsController::class, 'locate'])->middleware(['auth', 'verified','employee'])->name('locate');
Route::get('/items/{id}', [ItemsController::class, 'destroy'])->middleware(['auth', 'verified'])->name('items.delete');
Route::post('/items/{id}', [ItemsController::class, 'edit'])->middleware(['auth', 'verified'])->name('items.edit');
Route::get('/items', [ItemsController::class, 'list'])->middleware(['auth', 'verified'])->name('items.list');
Route::post('/items', [ItemsController::class, 'store'])->middleware(['auth', 'verified'])->name('items.create');

Route::get('/itemsS', [ItemsController::class, 'search'])->middleware(['auth', 'verified','employee'])->name('items.search');




require __DIR__ . '/auth.php';
