<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    //

    public function supplier()
    {
        return $this->belongsTo('App\Models\Supplier');
    }

    public function bills()
    {
        return $this->belongsToMany('App\Models\Bill')->withTimestamps()->withPivot('unit_price', 'quantity');
        //return $this->belongsToMany('App\Models\Bill')->withTimestamps();
    
    }

    public function restocks()
    {
        return $this->hasMany('App\Models\Restock');
    }
}
