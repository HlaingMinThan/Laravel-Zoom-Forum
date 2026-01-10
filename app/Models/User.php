<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Mail\OtpMail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

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
        return $this->hasMany(Question::class, "user_id");
    }

    public function answers()
    {
        return $this->hasMany(Answer::class);
    }
    public function generateOtpAndSend(){
        $otp = rand(100000,999999);
        
        // set otp code to password_reset_tokens table
        DB::transaction(function() use($otp){
            DB::table('password_reset_tokens')->updateOrInsert(
                ['email' => $this->email],
                [
                    'token' => Hash::make($otp),
                    'created_at' => now()
                    ]
                );
            });
        Mail::to($this->email)->queue(new OtpMail($otp));
        $expire_at = now()->addSeconds(180)->timestamp;
        return $expire_at;
    }
}
