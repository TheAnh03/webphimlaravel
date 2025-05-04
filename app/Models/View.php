<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class View extends Model
{
    use HasFactory;
    protected $fillable = ['movie_id', 'user_id', 'ip_address'];

    public function movie() {
        return $this->belongsTo(Movie::class);
    }
}
