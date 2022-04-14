<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Profile extends Model
{
    use HasFactory;

    protected $fillable = [
        'tagline', 'tags', 'level', 'avatar'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'avatar' => 'array',
    ];

    /**
     * Defines the relationships on the model
     * 
     * 
     */
    public function user() {
        return $this->belongsTo(User::class, 'id');
    }
}
