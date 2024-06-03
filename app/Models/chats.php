<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class chats extends Model
{
    use HasFactory;

    protected $fillable = [
        'm_from',
        'm_to',
        'messsage',
    ];

    /**
     * Get the user that sent the chat.
     */
    public function sender(): BelongsTo
    {
        return $this->belongsTo(User::class, 'm_from');
    }

    /**
     * Get the user that received the chat.
     */
    public function receiver(): BelongsTo
    {
        return $this->belongsTo(User::class, 'm_to');
    }
}
