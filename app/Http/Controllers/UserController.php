<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function show(User $user)
    {
        return inertia("Profile", [
            'user' => $user->loadCount(['questions', 'answers']),
            'questions' => $user->questions()->latest()->take(5)->get(),
            'answers' => $user->answers()->with('question')->latest()->take(5)->get(),
        ]);
    }
}
