<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BlogComment extends Model
{
    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function blog()
    {
        return $this->belongTo('App\Models\Blog');
    }
}
