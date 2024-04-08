<?php

use App\Http\Controllers\AttachController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\DetachController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\LogoutController;
use App\Http\Controllers\SignUpController;
use App\Http\Controllers\StoreController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Routes Without middleware (authentication)
Route::post('/register', SignUpController::class);
Route::post('/login', LoginController::class);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', LogoutController::class);

    Route::prefix('book')->group(function () {
        Route::post('', [BookController::class, 'create'])->name('book.create');
        Route::get('', [BookController::class, 'index'])->name('book.index');
        Route::get('/{id}', [BookController::class, 'show'])->name('book.show');
        Route::put('/{id}', [BookController::class, 'update'])->name('book.update');
        Route::delete('/{id}', [BookController::class, 'delete'])->name('book.delete');
    });

    Route::prefix('store')->group(function () {
        Route::post('', [StoreController::class, 'create'])->name('store.create');
        Route::get('', [StoreController::class, 'index'])->name('store.index');
        Route::get('/{id}', [StoreController::class, 'show'])->name('store.show');
        Route::put('/{id}', [StoreController::class, 'update'])->name('store.update');
        Route::delete('/{id}', [StoreController::class, 'delete'])->name('store.delete');
    });

    Route::post('book/store/attach', AttachController::class)->name('attach');
    Route::post('book/store/detach', DetachController::class)->name('detach');
});
