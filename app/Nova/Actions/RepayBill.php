<?php

namespace App\Nova\Actions;

use Illuminate\Bus\Queueable;
use Laravel\Nova\Actions\Action;
use Illuminate\Support\Collection;
use Laravel\Nova\Fields\ActionFields;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

use Laravel\Nova\Fields\Number;

use App\Models\Transaction;

class RepayBill extends Action
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
        foreach ($models AS $model) {
            $model->paid += $fields->amount;
            $model->save();

            $transaction = new Transaction;

            $transaction->action = 'R';
            $transaction->amount = $fields->amount;
            $transaction->details = 'Paid to Bill No: ' . $model->bill_no;
    
            $transaction->save();
        }
    }

    /**
     * Get the fields available on the action.
     *
     * @return array
     */
    public function fields()
    {
        return [
            Number::make('Amount')->min(0)->max(99999)->step(0.0001),
        ];
    }
}
