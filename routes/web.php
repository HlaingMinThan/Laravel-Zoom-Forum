<?php

use App\Http\Controllers\AnswerController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\UserController;
use App\Models\Question;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', [QuestionController::class, 'index'])->name('home');
Route::get('/questions/{id}', [QuestionController::class, 'show'])->name('questions.show');
Route::get('/users/{user}', [UserController::class, 'show'])->name('users.show');
Route::get('/questions/ask', [QuestionController::class, 'create'])->name('questions.create');
Route::post('/questions/store', [QuestionController::class, 'store'])->name('questions.store');
Route::post('/answers/store', [AnswerController::class, 'store'])->name('answers.store');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
