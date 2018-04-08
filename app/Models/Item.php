<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    protected $table = 'items';

    public function purchase()
    {
        return $this->belongsTo('App\Models\Purchase');
    }

    public function workshop()
    {
        return $this->belongsTo('App\Models\Workshop');
    }

    public function product()
    {
        return $this->belongsTo('App\Models\Product');
    }

    public function sales()
    {
        return $this->belongsTo('App\Models\Sale');
    }

    public function image()
    {
        return$this->hasMany('App\Models\Image', 'product_id', 'product_id');
    }
}
