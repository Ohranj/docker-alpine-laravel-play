<?php

namespace App\Models;

use App\Models\MessageReply;
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

    /**
     * Defines the relationships on the model
     * 
     * 
     */
    public function senderUser() {
        return $this->belongsTo(User::class, 'sender_id', 'id');
    }

    public function recipientUser() {
        return $this->belongsTo(User::class, 'recipient_id', 'id');
    }

    public function replies() {
        return $this->hasOne(MessageReply::class, 'message_id', 'id');
    }
}
