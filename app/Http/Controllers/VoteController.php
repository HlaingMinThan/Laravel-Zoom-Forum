<?php

namespace App\Http\Controllers;

use App\Models\Answer;
use App\Models\Question;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class VoteController extends Controller
{
    public function store()
    {
        $data = request()->validate([
            'type'  => ['required', 'in:question,answer'],
            'id'    => ['required', 'integer'],
            'value' => ['required', 'in:upvote,downvote'],
        ]);

        $userId = auth()->id();

        // Map type to model (or just keep the string if you prefer)
        $votableType = $data['type'] === 'answer' ? Answer::class : Question::class;
        $votableId   = (int) $data['id'];
        $newValue    = $data['value'];

        DB::transaction(function () use ($userId, $votableType, $votableId, $newValue) {
            $vote = \App\Models\Vote::where([
                'user_id' => $userId,
                'votable_type' => $votableType,
                'votable_id' => $votableId,
            ])->lockForUpdate()->first();


            if (!$vote) {
                \App\Models\Vote::create([
                    'user_id' => $userId,
                    'votable_type' => $votableType,
                    'votable_id' => $votableId,
                    'value' => $newValue,
                ]);
            } elseif ($vote->value === $newValue) {
                $vote->delete(); // toggle off
            } else {
                $vote->update(['value' => $newValue]); // switch
            }
        });

        return back();
    }
}
