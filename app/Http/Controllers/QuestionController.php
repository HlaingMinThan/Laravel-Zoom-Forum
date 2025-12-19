<?php

namespace App\Http\Controllers;

use App\Models\Question;
use App\Models\Vote;
use Illuminate\Http\Request;
use Inertia\Inertia;

class QuestionController extends Controller
{
    public function index()
    {
        $filters = request(['tag', 'query']); // associated array
        $questions = Question::with('user', 'tags')
            ->withCount("votes")
            ->latest()
            ->filter($filters);
        return inertia('Welcome', [
            'questions' => Inertia::scroll(fn() => $questions->paginate())
        ]);
    }

    public function show($id)
    {
        $question = Question::findOrFail($id);

        return inertia('QuestionDetail', [
            'question' => $question
                ->loadCount(['upvotes', 'downvotes'])
                ->load('user', 'tags', 'answers.user'),
            'myVote' => Vote::where("user_id", auth()->id())->where("votable_type", Question::class)->where("votable_id", $question->id)->first()?->value
        ]);
    }

    public function create()
    {
        return inertia('QuestionCreate');
    }

    public function store()
    {
        request()->validate([
            'title' => "required | min:5",
            'body' => "required",
        ]);
        $data = request()->all();
        $question = new Question();
        $question->title = $data['title'];
        $question->body = $data['body'];
        $question->user_id = auth()->id(); //2
        $question->save();

        return redirect('/');
    }
}
