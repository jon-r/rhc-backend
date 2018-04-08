<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    protected $table = 'items';

    protected $fillable = [
        'name',
        'status',
        'serial_number',
        'purchases_id',
        'purchased_date',
        'workshop_id',
        'workshop_out',
        'product_id',
        'date_on_site',
        ''
    ];

}
