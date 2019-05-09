<?php

namespace App\Nova;

use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Markdown;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\Date;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\BelongsToMany;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\File;


use Illuminate\Http\Request;
use Laravel\Nova\Http\Requests\NovaRequest;

class Bill extends Resource
{
    public static $with = ['products'];
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = 'App\Models\Bill';

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'bill_no';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'bill_no'
    ];

    /**
     * Get the fields displayed by the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function fields(Request $request)
    {
        return [
            ID::make()->sortable()->hideFromIndex(),
            Text::make('Bill No')->exceptOnForms(),
            BelongsTo::make('Supplier'),
            Number::make('USD->CNY', 'exchange_rate')
                ->min(0)->max(999)->step(0.0001)->hideFromIndex(),
            Number::make('Subtotal CNY', 'subtotal')
                ->min(0)->max(999999)->step(0.0001)->hideFromIndex(),
            
            Number::make('Local Freight CNY', 'local_freight')
                ->min(0)->max(9999)->step(0.01)->hideFromIndex(),
            Number::make('Total', function () {
                    return number_format($this->subtotal + $this->commission + $this->local_freight, 4, '.', '');
                })->onlyOnIndex(),
            Number::make('Paid')
                ->min(0)->max(999999)->step(0.0001)->exceptOnForms(),
            Number::make('Balance')
                ->min(0)->max(999999)->step(0.0001)->exceptOnForms()->sortable(),
            Select::make('Status')->options([
                    'W' => 'Waiting',
                    'O' => 'Ordered',
                    'D' => 'Depatched',
                    'P' => 'Partially Paid',
                    'C' => 'Completed',
                ])->displayUsingLabels()->sortable(),
            Date::make('Created At')->exceptOnForms(),
            Date::make('Due Date', 'due_at')->sortable(),
            Markdown::make('Comments'),  
            File::make('Invoice Path')->disk('public')->path('invoices'),

            BelongsToMany::make('Products')->fields(function () {
                return [
                    Number::make('Quantity'),
                    Number::make('Unit Price')
                        ->min(0)->max(999999)->step(0.0001),
                ];
            })->searchable(),
            
            ];
    }

    /**
     * Get the cards available for the request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function cards(Request $request)
    {
        return [
            new Metrics\TotalBalance,
            new Metrics\BalancePerSupplier,
        ];
    }

    /**
     * Get the filters available for the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function filters(Request $request)
    {
        return [];
    }

    /**
     * Get the lenses available for the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function lenses(Request $request)
    {
        return [];
    }

    /**
     * Get the actions available for the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function actions(Request $request)
    {
        return [
            new Actions\RepayBill,
            new Actions\UpdateBillLastestTotal
        ];
    }
}
