<?php

namespace App\Nova;

use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Markdown;
use Laravel\Nova\Fields\Avatar;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\BelongsToMany;
use Laravel\Nova\Fields\Boolean;

use Laravel\Nova\Panel;

use Illuminate\Http\Request;
use Laravel\Nova\Http\Requests\NovaRequest;

class Product extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = 'App\Models\Product';

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    //public static $title = 'name';
    public function title()
    {
        return $this->name . '- SKU: ' . $this->sku . ' - C: ' . $this->price_cny . ' - U: ' . $this->price_usd;
    }

    /**
     * Get the search result subtitle for the resource.
     *
     * @return string
     */
    public function subtitle()
    {
        return "Supplier: {$this->supplier->company_name}";
    }

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
            ID::make()->sortable()->hideFromIndex(),

            Avatar::make('Image Url')->disk('public')->path('cover_image'),
            Text::make('Product Name', 'name'),
            Text::make('Sku'),
            BelongsTo::make('Supplier'),
            Number::make('CN2AU Sea Freight CNY', 'sea_freight')->min(0)->max(9999)->step(0.01)->onlyOnDetail(),
            Number::make('Price USD')->min(0)->max(9999)->step(0.01)->hideFromIndex(),
            Number::make('Price CNY')->min(0)->max(9999)->step(0.01)->hideFromIndex(),
            new Panel('Package Informaion', $this->packageFields()),
            Markdown::make('Comments'),
            Number::make('Est Cost CNY', function () {
               $cost = $this->price_usd * config('xglobal.usd_to_cny') + $this->price_cny;
               return number_format($cost, 4, '.', '');
            })->onlyOnIndex(),  
            BelongsToMany::make('Bills')->fields(function () {
                return [
                    Number::make('Quantity'),
                    Number::make('Unit Price')
                        ->min(0)->max(999999)->step(0.0001),
                ];
            }),
        ];
        
    }

        /**
         * Get the package fields for the resource.
         *
         * @return array
         */
        protected function packageFields()
        {
            return [
                Number::make('Carton Quantity')->min(1)->max(999),
                Number::make('Carton Width (cm)', 'carton_width')->min(0.1)->max(1000)->step(0.01)->hideFromIndex(),
                Number::make('Carton Length (cm)', 'carton_length')->min(0.1)->max(1000)->step(0.01)->hideFromIndex(),
                Number::make('Carton Height (cm)', 'carton_height')->min(0.1)->max(1000)->step(0.01)->hideFromIndex(),
                Number::make('Carton Weight (kg)', 'carton_weight')->min(0.01)->max(1000)->step(0.01)->hideFromIndex(),
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
