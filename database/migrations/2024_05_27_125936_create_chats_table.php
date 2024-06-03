<?php

use App\Models\User;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('chats', function (Blueprint $table) {
            $table->id();
            $table->string('m_from');
            $table->string('m_to');
            $table->longText('message');
            $table->tinyInteger('status');
            $table->string('chn');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('chats');
    }

    /**
     * Get the user that sent the chat.
     */
    // public function sender(): BelongsTo
    // {
    //     return $this->belongsTo(User::class, 'm_from');
    // }

    // /**
    //  * Get the user that received the chat.
    //  */
    // public function receiver(): BelongsTo
    // {
    //     return $this->belongsTo(User::class, 'm_to');
    // }

};
