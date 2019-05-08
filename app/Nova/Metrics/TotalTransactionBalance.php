<?php

namespace App\Nova\Metrics;

use Illuminate\Http\Request;
use Laravel\Nova\Metrics\Value;

use App\Models\Transaction;

class TotalTransactionBalance extends Value
{
    /**
     * Calculate the value of the metric.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return mixed
     */
    public function calculate(Request $request)
    {
        $total_credit = Transaction::where('action', 'C')->sum('amount');
        $total_debit = Transaction::where('action', 'D')->sum('amount');
        $total_repay = Transaction::where('action', 'R')->sum('amount');

        $total_balance = $total_credit - $total_debit - $total_repay;
        return $this->result($total_balance)->previous(0);
    }

    /**
     * Get the ranges available for the metric.
     *
     * @return array
     */
    public function ranges()
    {
        return [
            
        ];
    }

    /**
     * Determine for how many minutes the metric should be cached.
     *
     * @return  \DateTimeInterface|\DateInterval|float|int
     */
    public function cacheFor()
    {
        // return now()->addMinutes(5);
    }

    /**
     * Get the URI key for the metric.
     *
     * @return string
     */
    public function uriKey()
    {
        return 'total-transaction-balance';
    }
}
