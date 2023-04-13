<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PDFController;
use App\Http\Controllers\ExpenseController;

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
//Auth::routes(['verify' => true]);

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    //notify()->success('⚡️ Bem vindo!'); //TEST TOAST NOTIFY
    //notify()->warning('⚡️ Bem vindo!'); //TEST TOAST NOTIFY
    //notify()->info('⚡️ Bem vindo!'); //TEST TOAST NOTIFY
    //notify()->error('⚡️ Bem vindo!'); //TEST TOAST NOTIFY
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

//Route::get('/dashboard',[ProfileController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/generate-pdf', [PDFController::class, 'generatePDF'])->name('generate-pdf');
    Route::get('/toggle-theme/{id}', [ProfileController::class, 'toggleTheme'])->name('toggle-theme');
    Route::get('/to-me', [ExpenseController::class, 'toMe'])->name('to-me');
    Route::get('/to-all', [ExpenseController::class, 'toAll'])->name('to-all');
    Route::get('/attach-user/{expense},{user}', [ExpenseController::class, 'attachUser'])->name('attach-user');
    Route::get('/detach-user/{expense}', [ExpenseController::class, 'detachUser'])->name('detach-user');
});

require __DIR__.'/auth.php';
