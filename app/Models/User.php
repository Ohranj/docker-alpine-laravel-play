<?php

namespace App\Models;

use App\Models\Message;
use App\Models\Profile;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'firstname', 'lastname', 'email', 'password', 'state', 'agenda'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Return a users full name
     * 
     * @return string;
     */
    public function getFullName()
    {
        return "{$this->firstname} {$this->lastname}";
    }

    /**
     * Return a users profile image
     * @return string;
     */
    public function getUserAvatar() {
        if ($this->profile->avatar['customPath']) {
            return 'storage/' . $this->profile->avatar['customPath'];
        } else {
            return $this->profile->avatar['defaultPath'];
        }
    }

    /**
     * Return an array of who the user is following
     * @return array
     */
    public function getUserFollowing() {
        return $this->followings()->get();
    }

    /**
     * Defines the relationships on the model
     * 
     * 
     */
    public function profile() {
        return $this->hasOne(Profile::class, 'user_id');
    }

    public function followings() {
        return $this->belongsToMany(User::class, 'following_user', 'user_id', 'following_id');
    }

    public function followers() {
        return $this->belongsToMany(User::class, 'following_user', 'following_id', 'user_id');
    }

    public function sent_messages() {
        return $this->hasMany(Message::class, 'messages', 'user_id', 'sender_id');
    }

    public function received_messages() {
        return $this->hasMany(Message::class, 'messages', 'user_id', 'recipient_id');
    }
}
