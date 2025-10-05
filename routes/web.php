<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ActivityController;
use App\Http\Controllers\ActivityUpdateController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/register',[AuthController::class, 'showRegister'])->name('show.register');
Route::get('/login',[AuthController::class, 'showLogin'])->name('show.login');
Route::post('/register',[AuthController::class, 'register'])->name('register');
Route::post('/login',[AuthController::class, 'login'])->name('login');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');


Route::middleware(['auth'])->group(function () {


   Route::get('activities', [ActivityController::class, 'index'])->name('activities.index');


    Route::get('activities/create', [ActivityController::class, 'create'])->name('activities.create');
    Route::get('activities/daily', [ActivityController::class, 'showDailyView'])->name('activities.daily');
    Route::get('activities/report', [ActivityController::class, 'showReport'])->name('activities.report');



    Route::post('activities', [ActivityController::class, 'store'])->name('activities.store');


    Route::get('activities/{activity}', [ActivityController::class, 'show'])->name('activities.show');


    Route::get('activities/{activity}/edit', [ActivityController::class, 'edit'])->name('activities.edit');


    Route::put('activities/{activity}', [ActivityController::class, 'update'])->name('activities.update');

    Route::delete('activities/{activity}', [ActivityController::class, 'destroy'])->name('activities.destroy');

    Route::get('activities/{activity}/updates/create', [ActivityUpdateController::class, 'create'])
        ->name('activity_updates.create');

    Route::post('activity-updates', [ActivityUpdateController::class, 'store'])
        ->name('activity_updates.store');

    Route::get('activity-updates/{activityUpdate}/edit', [ActivityUpdateController::class, 'edit'])
        ->name('activity_updates.edit');

    Route::put('activity-updates/{activityUpdate}', [ActivityUpdateController::class, 'update'])
        ->name('activity_updates.update');

    Route::delete('activity-updates/{activityUpdate}', [ActivityUpdateController::class, 'destroy'])
        ->name('activity_updates.destroy');
});

