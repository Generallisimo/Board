<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Message extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = false;

    public function chats(): BelongsTo
    {
        return $this->belongsTo(Chat::class);
    }
    
    public function users():BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
