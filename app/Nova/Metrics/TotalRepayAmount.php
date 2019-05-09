<?php

namespace App\Nova\Metrics;

use Illuminate\Http\Request;
use Laravel\Nova\Metrics\Value;

use App\Models\Transaction;

class TotalRepayAmount extends Value
{
    /**
     * Calculate the value of the metric.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return mixed
     */
    public function calculate(Request $request)
    {
        $prev_start_time = $this->previousRange($request->range)[0];
        $prev_end_time = $this->previousRange($request->range)[1];
        $curr_start_time = $this->currentRange($request->range)[0];
        $curr_end_time = $this->currentRange($request->range)[1];

        $previousTotal = Transaction::where('action', 'R')->whereBetween('created_at', [$prev_start_time, $prev_end_time])->sum('amount');
        $recentTotal = Transaction::where('action', 'R')->whereBetween('created_at', [$curr_start_time, $curr_end_time])->sum('amount');

        return $this->result($recentTotal)->previous($previousTotal);
    }

    /**
     * Get the ranges available for the metric.
     *
     * @return array
     */
    public function ranges()
    {
        return [
            30 => '30 Days',
            90 => '90 Days',
            365 => '365 Days',
            'MTD' => 'Month To Date',
            'QTD' => 'Quarter To Date',
            'YTD' => 'Year To Date',
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
        return 'total-repay-amount';
    }
}
