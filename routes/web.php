<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\ResponseController;
use App\Http\Controllers\ResponseProgressController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('landing-page');
});

Route::middleware(['isNotLogin'])->group(function () {
    Route::get('login', function() {
        return view('login');
    })->name('login');
    Route::post('login', [AuthController::class, 'loginorRegister'])->name('auth.login');
});

Route::middleware(['isLogin'])->group(function () {
    Route::get('logout', [AuthController::class, 'logout'])->name('auth.logout');
});

Route::middleware(['isGuest'])->group(function () {
    Route::prefix('/report')->name('report.')->group(function() {
        Route::get('articles', [ReportController::class, 'index'])->name('articles');
        Route::get('articles/{id}', [ReportController::class, 'show'])->name('articles.show');
        Route::post('articles/{id}', [ReportController::class, 'voting'])->name('articles.voting');
        // Route::get('articles/{id}', [CommentController::class, 'store'])->name('comments.store');
        Route::get('create', [ReportController::class, 'create'])->name('create');
        Route::post('create', [ReportController::class, 'store'])->name('store');
        Route::get('me', [ReportController::class, 'me'])->name('me');
        Route::delete('me/{id}', [ReportController::class, 'destroy'])->name('destroy');
        
    });

    Route::post('comments', [CommentController::class, 'store'])->name('comments.store');
});

// export excel
Route::prefix('/report')->name('report.')->group(function() {
    Route::get('export-all', [ReportController::class, 'exportAll'])->name('export-all');
    Route::get('export-date', [ReportController::class, 'exportDate'])->name('export-date');
});

Route::middleware(['isStaff'])->group(function () {
    Route::prefix('/report')->name('report.')->group(function() {
        Route::get('/', [ReportController::class, 'indexStaff'])->name('index');
    });

    Route::prefix('response')->name('response.')->group(function() {
        Route::get('report', [ResponseController::class, 'index'])->name('report');
        Route::post('report/{id}/response', [ResponseController::class, 'store'])->name('report.store');
        Route::post('report/{id}/progress', [ResponseProgressController::class, 'store'])->name('progress.store');
        Route::get('report/{id}', [ResponseController::class, 'show'])->name('report.show');
        Route::delete('report/{id}', [ResponseController::class, 'destroy'])->name('report.destroy');
        // Route::delete('/report/{reportId}/progress/{progressId}', [ResponseProgressController::class, 'destroy'])->name('report.destroy');

        Route::post('report/{id}/complete', [ResponseController::class, 'completeReport'])->name('report.completed');
    });
});

Route::middleware(['isHeadStaff'])->group(function () {
    Route::get('/report/dashboard', [ReportController::class, 'indexHeadStaff'])->name('report.dashboard');

    Route::prefix('/user')->name('user.')->group(function() {
        Route::get('/', [UserController::class, 'index'])->name('user');
        Route::post('/', [UserController::class, 'store'])->name('store');
        Route::post('/{id}', [UserController::class, 'resetPassword'])->name('reset');
        Route::delete('/{id}', [UserController::class, 'destroy'])->name('destroy');
    });
});