<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Workshop extends Model
{
    protected $table = 'workshop';

    public function item()
    {
        return $this->hasOne('App\Models\Item');
    }

    public function work()
    {
        return $this->hasMany('App\Models\WorkshopWork');
    }

    public function parts()
    {
        return $this->hasMany('App\Models\WorkshopParts');
    }
}
