<?php

namespace App\Nova\Actions;

use Illuminate\Bus\Queueable;
use Laravel\Nova\Actions\Action;
use Illuminate\Support\Collection;
use Laravel\Nova\Fields\ActionFields;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class UpdateBillLastestTotal extends Action
{
    use InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Perform the action on the given models.
     *
     * @param  \Laravel\Nova\Fields\ActionFields  $fields
     * @param  \Illuminate\Support\Collection  $models
     * @return mixed
     */
    public function handle(ActionFields $fields, Collection $models)
    {
        //
        foreach ($models As $model) {

            if($model->status == 'C') {
                return Action::danger('Cannot update a completed order!');
            }

            $subtotal = 0;

            foreach($model->products As $product) {
                $product->pivot->unit_price = $product->price_cny + $product->price_usd * $model->exchange_rate + $product->sea_freight;
                $product->pivot->update();
                $subtotal += $product->pivot->unit_price * $product->pivot->quantity;
            }
            
            $model->subtotal = $subtotal;
            $model->save();
        }
    }

    /**
     * Get the fields available on the action.
     *
     * @return array
     */
    public function fields()
    {
        return [];
    }
}
