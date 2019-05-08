<?php

namespace App\Nova;

use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Date;
use Laravel\Nova\Fields\Markdown;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Status;

use Illuminate\Http\Request;
use Laravel\Nova\Http\Requests\NovaRequest;

class Restock extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = 'App\Models\Restock';

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'name';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'sku', 'name'
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

            Text::make('Product Name', 'name')->onlyOnForms(),
            Text::make('Sku')->onlyOnForms(),
            BelongsTo::make('Product'),
            BelongsTo::make('Supplier'),
            Number::make('Require Qty'),
            Date::make('Runout At'),
            Number::make('Order Qty'),
            Date::make('Deliver At'),
            Text::make('Bill No'),
            Date::make('Created At')->exceptOnForms(),
            Markdown::make('Comments')->alwaysShow(),
            Select::make('Status')->options([
                'Waiting' => 'Waiting',
                'Running' => 'Running',
                'Completed' => 'Completed',
            ])->displayUsingLabels()->onlyOnForms(),
            Status::make('Status')
                ->loadingWhen(['Waiting', 'Running'])
                ->failedWhen(['Completed'])->sortable(),
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
        return [];
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
        return [];
    }
}
