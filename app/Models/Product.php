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
        return $this->belongsToMany('App\Models\Product', 'rhc_related', 'product_id', 'related_id');
    }

    public function items()
    {
        return $this->hasMany('App\Models\Item');
    }

    public function sales()
    {
        return $this->belongsToMany('App\Models\Sale', 'items', 'product_id', 'sales_id');
    }

    public function workshop()
    {
        return $this->belongsToMany('App\Models\Workshop', 'items', 'product_id', 'workshop_id');
    }

    public function brand()
    {
        return $this->belongsTo('App\Models\Brand', 'brand_id');
    }
}
