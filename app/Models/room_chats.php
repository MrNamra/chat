<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class room_chats extends Model
{
    use HasFactory;

    protected $fillable = [
        'm_from',
        'room_id',
        'messsage',
    ];
}
