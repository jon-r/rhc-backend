<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    protected $table = 'rhc_brands';

    public function products()
    {
        return $this->hasMany('App\Models\Product');
    }

    public function image()
    {
        return $this->belongsTo('App\Models\SiteImage');
    }
}