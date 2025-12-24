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
            ->withCount("answers", 'votes')
            ->latest()
            ->filter($filters)
            ->paginate(10)
            ->through(function ($q) {
                $q->authorize = $q->user_id == auth()->id();
                return $q;
            });
        return inertia('Welcome', [
            'questions' => $questions
        ]);
    }

    public function show($id)
    {
        $question = Question::findOrFail($id);
        $answers =  $question->answers()
            ->with('user')
            ->withCount(['upvotes', 'downvotes'])
            ->paginate(10)
            ->through(function ($answer) {
                $vote = $answer->votes()->where('user_id', auth()->id())->first()?->value;
                $answer->userVote = $vote;
                return $answer;
            });
        return inertia('QuestionDetail', [
            'question' => $question->load([
                'user',
                'tags'
            ])->loadCount('upvotes', 'downvotes'),
            'answers' => $answers,
            'userVote' => $question->votes()
                ->where('user_id', auth()->id())
                ->first()?->value
        ]);
    }

    public function create()
    {
        return inertia('QuestionForm');
    }
    public function edit(Question $question)
    {
        if (!auth()->user()->can("authorize", $question)) {
            return redirect('/');
        }
        return inertia('QuestionForm', [
            'question' => $question
        ]);
    }
    public function update(Question $question)
    {
        if (!auth()->user()->can("authorize", $question)) {
            return redirect('/');
        }
        request()->validate([
            'title' => "required | min:5",
            'body' => "required",
        ]);
        $data = request()->all();
        $question->title = $data['title'];
        $question->body = $data['body'];
        $question->save();

        return redirect('/');
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

    public function destroy(Question $question)
    {
        if (!auth()->user()->can("authorize", $question)) {
            return redirect('/');
        }
        $question->delete();
        return back();
    }
}
