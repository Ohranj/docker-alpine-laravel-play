<?php

namespace App\Models;

use Illuminate\Support\Facades\Crypt;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Message extends Model
{
    use HasFactory;

    public function setEncrypt($column, $value) {
        return $this->attributes[$column] = Crypt::encryptString($value);
    }

    // protected $dispatchesEvents = [
    //     'saved' => UserSaved::class,
    //     'deleted' => UserDeleted::class,
    // https://laravel.com/docs/9.x/eloquent#events
    // ];
}
