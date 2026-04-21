<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProgramController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\UserManagementController;
use Illuminate\Support\Facades\Route;

Route::redirect('/', '/login')->name('home');

Route::middleware(['auth'])->group(function () {
    Route::get('dashboard', HomeController::class)->name('dashboard');

    Route::get('programs', [ProgramController::class, 'index'])->name('programs.index');
    Route::get('subjects', [SubjectController::class, 'index'])->name('subjects.index');

    Route::middleware('role:admin,staff')->group(function () {
        Route::get('programs/create', [ProgramController::class, 'create'])->name('programs.create');
        Route::post('programs', [ProgramController::class, 'store'])->name('programs.store');
        Route::get('programs/{program}/edit', [ProgramController::class, 'edit'])->name('programs.edit');
        Route::put('programs/{program}', [ProgramController::class, 'update'])->name('programs.update');

        Route::get('subjects/create', [SubjectController::class, 'create'])->name('subjects.create');
        Route::post('subjects', [SubjectController::class, 'store'])->name('subjects.store');
        Route::get('subjects/{subject}/edit', [SubjectController::class, 'edit'])->name('subjects.edit');
        Route::put('subjects/{subject}', [SubjectController::class, 'update'])->name('subjects.update');
    });

    Route::middleware('role:admin')->group(function () {
        Route::get('users', [UserManagementController::class, 'index'])->name('users.index');
        Route::get('users/create', [UserManagementController::class, 'create'])->name('users.create');
        Route::post('users', [UserManagementController::class, 'store'])->name('users.store');
        Route::get('users/{user}/edit', [UserManagementController::class, 'edit'])->name('users.edit');
        Route::put('users/{user}', [UserManagementController::class, 'update'])->name('users.update');
        Route::delete('users/{user}', [UserManagementController::class, 'destroy'])->name('users.destroy');
    });
});

require __DIR__.'/settings.php';
