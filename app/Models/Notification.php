<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id','movie_id', 'message', 'link', 'is_read'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function movie()
    {
        
        return $this->belongsTo(Movie::class);
    }
    
}
 