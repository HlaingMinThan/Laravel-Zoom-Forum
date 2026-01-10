<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // a user hasMany questions
    public function questions()
    {
        return $this->hasMany(Question::class, 'user_id');
    }

    public function answers()
    {
        return $this->hasMany(Answer::class);
    }

    /**
     * Calculate total points from answer upvotes.
     * Each upvote on an answer = 1 point.
     */
    public function getPoints(): int
    {
        return $this->answers()
            ->withCount(['upvotes'])
            ->get()
            ->sum('upvotes_count');
    }

    /**
     * Get badge name based on points.
     * Newbie: 0-4 points
     * Helper: 5-19 points
     * Expert: 20+ points
     */
    public function getBadge(): string
    {
        $points = $this->getPoints();

        if ($points >= 20) {
            return 'expert';
        }

        if ($points >= 5) {
            return 'helper';
        }

        return 'newbie';
    }

    /**
     * Get badge display name.
     */
    public function getBadgeDisplayName(): string
    {
        return ucfirst($this->getBadge());
    }
}
