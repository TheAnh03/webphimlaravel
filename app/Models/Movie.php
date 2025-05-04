<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Movie extends Model
{
   
    use HasFactory;
    public function category()
    {
        return $this->belongsTo(Category::class,'category_id');
    }
    
    public function movie_genre()
    {
        return $this->belongsToMany(Genre::class,'movie_genre','movie_id','genre_id');
    }
    public function country()
    {
        return $this->belongsTo(Country::class,'country_id');
    }
    
    public function episodes()
    {
        return $this->hasMany(Episode::class);
    }
    public function usersWhoFavorited()
    {
        return $this->belongsToMany(User::class, 'favorites', 'movie_id', 'user_id');
    }
   
    public function views()
    {
        return $this->hasMany(View::class);
    }
    // rating
    public function ratings()
    {
        return $this->hasMany(Rating::class);
    }
    public function getAverageRatingAttribute()
    {
        return round($this->ratings()->avg('ratepoint'), 1);
    }
    public function getRatingCountAttribute()
    {
        return $this->ratings()->whereNotNull('ratepoint')->count();
    }

    protected $fillable = [
        'title',
        'slug',
        'name_eng',
        'description',
        'episode',
        'trailer',
        'duration',
        'category_id',
        'country_id',
        'image',
        'isHot',
        'resolution',
        'season',
        'subtitle',
        'year',
        'status',
        'leech_index',
    ];
    


}
