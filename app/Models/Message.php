<?php

namespace App\Models;

use App\Events\MessageRetrievedEvent;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Message extends Model
{
    use HasFactory;

    /**
     * Map events to model
     * 
     * @var array
     */
    protected $dispatchesEvents = [
        'retrieved' => MessageRetrievedEvent::class
    ];

    public function setEncrypt($column, $value) {
        return $this->attributes[$column] = Crypt::encryptString($value);
    }
}
