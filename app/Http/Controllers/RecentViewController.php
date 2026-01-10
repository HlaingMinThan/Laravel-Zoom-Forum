<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Inertia\Inertia;
use Illuminate\Support\Facades\DB;

class RecentViewController extends Controller
{
    public function recordView(Request $request, $question_id)
    {

        if (!$question_id || $question_id == 'undefined') {
            return response()->json(['success' => false, 'message' => 'Invalid ID'], 400);
        }

        if (auth()->check()) {
            $user_id = auth()->id();

            DB::table('recent_views')->updateOrInsert(
                ['user_id' => $user_id, 'question_id' => $question_id],
                ['viewed_at' => now()]
            );

            return response()->json(['success' => true]);
        }

        return response()->json(['success' => false], 401);
    }

    // UserController.php

    public function show(User $user)
    {

        $recentViews = $user->recentQuestions()->take(10)->get();

        return Inertia::render('User/Show', [
            'user' => $user,
            'recentQuestions' => $recentViews
        ]);
    }
}
