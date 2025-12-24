<?php

use App\Http\Controllers\AnswerController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VoteController;
use App\Http\Middleware\AuthMiddleware;
use App\Models\Question;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', [QuestionController::class, 'index'])->name('home');
Route::get('/users/{user}', [UserController::class, 'show'])->name('users.show');
Route::get('/questions/ask', [QuestionController::class, 'create'])->name('questions.create');
Route::get('/questions/{question}/edit', [QuestionController::class, 'edit'])->name('questions.edit')->middleware(AuthMiddleware::class);
Route::put('/questions/{question}/update', [QuestionController::class, 'update'])->name('questions.update');
Route::post('/questions/store', [QuestionController::class, 'store'])->name('questions.store');
Route::get('/questions/{id}', [QuestionController::class, 'show'])->name('questions.show');
Route::delete('/questions/{question}/destroy', [QuestionController::class, 'destroy'])->name('questions.destroy');
Route::post('/answers/store', [AnswerController::class, 'store'])->name('answers.store')->middleware(AuthMiddleware::class);

Route::post('/votes', [VoteController::class, 'toggle'])->name('votes.toggle')->middleware(AuthMiddleware::class);
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
