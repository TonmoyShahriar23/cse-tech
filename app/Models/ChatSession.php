<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChatSession extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'last_message_at',
        'is_pinned',
        'pinned_at',
    ];

    protected $casts = [
        'last_message_at' => 'datetime',
        'pinned_at' => 'datetime',
        'is_pinned' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function messages()
    {
        return $this->hasMany(Chat::class, 'session_id');
    }

    public function updateLastMessageTime()
    {
        $this->last_message_at = now();
        $this->save();
    }

    public function togglePin()
    {
        $this->is_pinned = !$this->is_pinned;
        $this->pinned_at = $this->is_pinned ? now() : null;
        $this->save();
    }
}