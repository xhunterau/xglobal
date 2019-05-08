<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Laravel\Nova\Actions\Actionable;

class Bill extends Model
{
    use Actionable;
    
    public $incrementing = true;
    
    protected $dates = [
        'due_at',
    ];
    //
    public function supplier()
    {
        return $this->belongsTo('App\Models\Supplier');
    }

    public function products()
    {
        return $this->belongsToMany('App\Models\Product')->withTimestamps()->withPivot('unit_price', 'quantity');
        //return $this->belongsToMany('App\Models\Product')->withTimestamps();
    }
}
