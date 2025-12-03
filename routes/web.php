<?php

use App\Http\Controllers\ProfileController;
use App\Models\Question;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    $search = request('query');
    if ($search) {
        $questions = Question::where("title", "LIKE", "%" . $search . "%")->get();
    } else {
        $questions = Question::with('user')->latest()->get(); //eager loading
    }
    return inertia('Welcome', [
        'questions' => $questions
    ]);
});

Route::get('/questions/{id}', function ($id) {
    $question = Question::findOrFail($id);
    return inertia('QuestionDetail', [
        'question' => $question->load('user')
    ]);
});

Route::get("/about", function () {
    return inertia("about");
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
