<?php

use App\Http\Controllers\ArticleController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Models\Article;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    // Route::get('/permissions/create', [PermissionController::class, 'create'])->name('permissions.create');
    // Route::post('/permissions/store', [PermissionController::class, 'store'])->name('permissions.store');
    // Route::get('/permissions/index', [PermissionController::class, 'index'])->name('permissions.index');
    // Route::get('/permissions/edit/{id}', [PermissionController::class, 'edit'])->name('permissions.edit');
    // Route::put('/permissions/update/{id}', [PermissionController::class, 'update'])->name('permissions.update');
    // Route::delete('/permissions/delete/{id}', [PermissionController::class, 'delete'])->name('permissions.delete');
    // Route::delete('/permissions/destroy/{id}', [PermissionController::class, 'destroy'])->name('permissions.destroy');

    Route::group(['middleware' =>
    ['permission:delete-permissions
                |create-permissions
                |view-permissions
                |edit-permissions']], function () {
        Route::resource('permissions', PermissionController::class);
    });
    Route::resource('role', RoleController::class);
    Route::resource('article', ArticleController::class);
    Route::resource('user', UserController::class);
});

require __DIR__ . '/auth.php';
