<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;


class Group extends Model
{
    protected $table = 'rhc_groups';

    public function categories()
    {
        return $this->hasMany('App\Models\Category', '');
    }

}