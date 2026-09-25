<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class AIConversation extends Model
{
    use HasFactory;

    protected $table = 'ai_conversations';

    protected $fillable = [
        'session_id',
        'lead_name',
        'lead_email',
        'lead_phone',
        'ip_address',
        'country',
    ];

    public function messages(): HasMany
    {
        return $this->hasMany(AIMessage::class, 'conversation_id');
    }

    public function inquiries(): HasMany
    {
        return $this->hasMany(Inquiry::class, 'conversation_id');
    }

    public function inquiry()
    {
        return $this->hasOne(Inquiry::class, 'conversation_id')->latestOfMany();
    }
}
