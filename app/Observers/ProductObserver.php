<?php

namespace App\Observers;

use App\Models\Product;

class ProductObserver
{
    /**
     * Handle the product "retrieved" event.
     *
     * @param  \App\Models\Product  $product
     * @return void
     */
    public function retrieved(Product $product)
    {
        //
        $cubic_weight = ($product->carton_width * $product->carton_length * $product->carton_height) / 5000;

        $dead_weight = max($cubic_weight, $product->carton_weight);

        $product->sea_freight = ($dead_weight * config('xglobal.freight_per_kg')) / $product->carton_quantity;
        
        $product->save();
    }

    /**
     * Handle the product "creating" event.
     *
     * @param  \App\Models\Product  $product
     * @return void
     */
    public function creating(Product $product)
    {
        //
        $product->sea_freight = 0;
    }

    /**
     * Handle the product "created" event.
     *
     * @param  \App\Models\Product  $product
     * @return void
     */
    public function created(Product $product)
    {
        //
    }

    /**
     * Handle the product "updated" event.
     *
     * @param  \App\Models\Product  $product
     * @return void
     */
    public function updated(Product $product)
    {
        //

    }

    public function saving(Product $product)
    {
        
    }

    

    /**
     * Handle the product "deleted" event.
     *
     * @param  \App\Models\Product  $product
     * @return void
     */
    public function deleted(Product $product)
    {
        //
    }

    /**
     * Handle the product "restored" event.
     *
     * @param  \App\Models\Product  $product
     * @return void
     */
    public function restored(Product $product)
    {
        //
    }

    /**
     * Handle the product "force deleted" event.
     *
     * @param  \App\Models\Product  $product
     * @return void
     */
    public function forceDeleted(Product $product)
    {
        //
    }
}
