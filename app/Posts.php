<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Posts extends Model
{
    protected $table = "posts";

    public function category()
    {
    	return $this->belongsTo("App\Category");
    }

    public function users()
    {
    	return $this->belongsTo("App\User");
    }
}
