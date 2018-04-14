<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = 'rhc_categories';

    protected $fillable = [
        'cat_name',
        'slug',
        'sort_order',
        'group_id',
        'description',
        'image_link',
    ];

    public $timestamps = false;

    public function image()
    {
        return $this->belongsTo('App\Models\SiteImage');
    }
}
