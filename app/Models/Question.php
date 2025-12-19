<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    /** @use HasFactory<\Database\Factories\QuestionFactory> */
    use HasFactory;

    protected $fillable = ['title', 'body', 'user_id'];

    // a question belongsTo a user
    public function user()
    {
        return $this->belongsTo(User::class, "user_id");
    }
    // a question belongstoMany tags
    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }

    public function scopeFilter($query, $filters)
    {
        if (isset($filters['query'])) {
            $query->where("title", "LIKE", "%" . $filters['query'] . "%");
        }
        if (isset($filters['tag'])) {
            $query->whereHas("tags", function ($q) use ($filters) {
                $q->where("id", $filters['tag']);
            });
        }
    }
    // a question hasMany answers
    public function answers()
    {
        return $this->hasMany(Answer::class, 'question_id');
    }

    public function votes()
    {
        return $this->morphMany(Vote::class, 'votable');
    }

    public function upvotes()
    {
        return $this->morphMany(Vote::class, 'votable')
            ->where('value', 'upvote');
    }

    public function downvotes()
    {
        return $this->morphMany(Vote::class, 'votable')
            ->where('value', 'downvote');
    }
}

//question model -> tag -> questions
// tag model -> questions ($tag->questions)