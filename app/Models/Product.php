<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = 'rhc_products';

    public function categories()
    {
        return $this->belongsToMany('App\Models\Category', 'rhc_categories_xrefs');
    }

    public function specs()
    {
        return $this->hasMany('App\Models\Spec');
    }

    public function tags()
    {
        return $this->belongsToMany('App\Models\Tag', 'rhc_tags_xrefs');
    }

    public function images()
    {
        return $this->hasMany('App\Models\Image');
    }

    public function related()
    {
        return $this->belongsToMany(
            'App\Models\Product',
            'rhc_related',
            'product_id',
            'related_id'
        );
    }


}
