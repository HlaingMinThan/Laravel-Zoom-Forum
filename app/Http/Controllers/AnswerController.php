<?php

namespace App\Http\Controllers;

use App\Models\Answer;
use App\Models\Question;
use Illuminate\Http\Request;

class AnswerController extends Controller
{
    public function store()
    {
        request()->validate([
            'answer' => "required",
            'question_id' => "required",
        ]);
        $question = Question::find(request('question_id'));
        $question->answers()->create([
            'body' => request('answer'),
            'user_id' =>  auth()->id()
        ]);
        return back();
    }
}
