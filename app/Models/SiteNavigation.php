<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SiteNavigation extends Model
{
    protected $table = 'site_navigation';

    public function image()
    {
        return $this->belongsTo('App\Models\SiteImage');
    }
}