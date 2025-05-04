<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Episode extends Model
{
    use HasFactory;
    public function movie()
{
    return $this->belongsTo(Movie::class);
}
public function server()
{
    return $this->belongsTo(Server::class);
}
protected $fillable = ['movie_id', 'server_id', 'episode', 'link'];

}
