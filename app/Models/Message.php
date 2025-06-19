<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $table = 'messages';
    protected $primaryKey = 'message_id';
    public $timestamps = false;
    
    protected $fillable = [
        'sender_id', 'message', 'timestamp'
    ];
    
    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id', 'user_id');
    }
}