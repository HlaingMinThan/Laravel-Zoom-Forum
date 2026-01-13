<?php

namespace App\Http\Controllers;

use App\Models\Answer;
use App\Models\Question;
use App\Models\Vote;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
            ->orderByRaw('id = ? DESC', [$question->best_answer_id])
            ->orderBy('created_at', 'desc')
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

    public function markBest(Request $request, $id)
    {
        $question = Question::findOrFail($id);
        if ($question->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }
        $request->validate([
            'answer_id' => 'required',
        ]);

        $answer = Answer::findOrFail($request->answer_id);
        if ($answer->question_id !== $question->id) {
            abort(403, 'This answer does not belong to this question.');
        }
        if ($question->best_answer_id == $answer->id) {
            $question->best_answer_id = null;
        } else {
            $question->best_answer_id = $answer->id;
        }

        $question->save();

        return back();
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
