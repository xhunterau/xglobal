<?php

namespace App\Observers;

use App\Models\Bill;
use Carbon\Carbon;

class BillObserver
{
    /**
     * Handle the bill "creating" event.
     *
     * @param  \App\Models\Bill  $bill
     * @return void
     */
    public function creating(Bill $bill)
    {
        //
        $bill->bill_no = 'XSY';
        $bill->balance = 0;
        $bill->paid = 0;
    }
    
    /**
     * Handle the bill "created" event.
     *
     * @param  \App\Models\Bill  $bill
     * @return void
     */
    public function created(Bill $bill)
    {
        //
        $bill->bill_no = sprintf("XSY-%'.05d\n", $bill->id);

        $bill->save();
    }

    /**
     * Handle the bill "retrieved" event.
     *
     * @param  \App\Models\Bill  $bill
     * @return void
     */
        public function retrieved(Bill $bill)
        {
            //
            if($bill->status != 'C') {
                $subtotal = 0;

                foreach($bill->products As $product) {
                    $product->pivot->unit_price = $product->price_cny + $product->price_usd * $bill->exchange_rate + $product->sea_freight;
                    $product->pivot->update();
                    $subtotal += $product->pivot->unit_price * $product->pivot->quantity;
                }
            
                $bill->subtotal = $subtotal;
                $bill->save();
            }

            
        }

    /**
     * Handle the bill "updated" event.
     *
     * @param  \App\Models\Bill  $bill
     * @return void
     */
    public function updated(Bill $bill)
    {
        //

    }

     /**
     * Handle the bill "updating" event.
     *
     * @param  \App\Models\Bill  $bill
     * @return void
     */
    public function updating(Bill $bill)
    {
        //
        $bill->balance = $bill->subtotal + $bill->commission + $bill->local_freight - $bill->paid;

        if ($bill->balance == 0) {
            $bill->status = 'C';
        } else if($bill->paid != 0) {
            $bill->status = 'P';
        }
    }

    /**
     * Handle the bill "deleted" event.
     *
     * @param  \App\Models\Bill  $bill
     * @return void
     */
    public function deleted(Bill $bill)
    {
        //
    }

    /**
     * Handle the bill "restored" event.
     *
     * @param  \App\Models\Bill  $bill
     * @return void
     */
    public function restored(Bill $bill)
    {
        //
    }

    /**
     * Handle the bill "force deleted" event.
     *
     * @param  \App\Models\Bill  $bill
     * @return void
     */
    public function forceDeleted(Bill $bill)
    {
        //
    }
}
