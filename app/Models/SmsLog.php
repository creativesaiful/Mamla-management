<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SmsLog extends Model
{
    
    protected $fillable = [
         'mobile',
        'message',
        'status',
        'provider',
        'response',
        'chamber_id',
        'user_id'
    ];

    public function chamber()
    {
        return $this->belongsTo(Chamber::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
