<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Decoration extends Model
{
    public $timestamps = false;
    use HasFactory;
    protected $table = 'decoration';
    protected $filltable = ['title','description','logo'];
}
