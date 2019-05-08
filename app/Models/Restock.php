<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Restock extends Model
{
    //
    protected $dates = [
        'runout_at',
        'deliver_at',
    ];
    
    public function product()
    {
        return $this->belongsTo('App\Models\Product');
    }

    public function supplier()
    {
        return $this->belongsTo('App\Models\Supplier');
    }
}
