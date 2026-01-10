<?php

namespace App\Http\Controllers;

use App\Models\User;

class UserController extends Controller
{
    public function show(User $user)
    {
        $points = $user->getPoints();
        $badge = $user->getBadge();

        $userData = $user->loadCount(['questions', 'answers'])->toArray();
        $userData['points'] = $points;
        $userData['badge'] = $badge;
        $userData['badge_display_name'] = $user->getBadgeDisplayName();

        return inertia('Profile', [
            'user' => $userData,
            'questions' => $user->questions()->latest()->take(5)->get(),
            'answers' => $user->answers()->with('question')->latest()->take(5)->get(),
        ]);
    }
}
