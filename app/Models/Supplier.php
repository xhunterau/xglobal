<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    //
    public function products()
    {
        return $this->hasMany('App\Models\Product');
    }

    public function bills()
    {
        return $this->hasMany('App\Models\Bill');
    }

    public function restocks()
    {
        return $this->hasMany('App\Models\Restock');
    }
}
