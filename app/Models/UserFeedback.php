<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserFeedback extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'manager_id',
        'message',
        'date',
    ];
    
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    
    public function manager()
    {
        return $this->belongsTo(User::class, 'manager_id');
    }
}
