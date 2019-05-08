<?php

namespace App\Nova;

use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Markdown;
use Laravel\Nova\Fields\HasMany;

use Laravel\Nova\Panel;


use Illuminate\Http\Request;
use Laravel\Nova\Http\Requests\NovaRequest;

class Supplier extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = 'App\Models\Supplier';

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'contact_person';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'company_name', 'contact_person'
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
            ID::make()->sortable(),
            Text::make('Company Name'),
            Text::make('Contact Person'),
            Markdown::make('Comments'),
            new Panel('Contact Information', $this->contactFields()),
            new Panel('Payment Information', $this->paymentFields()),
            HasMany::make('Products'),   
            HasMany::make('Bills'),        
        ];
    }

    /**
     * Get the contact fields for the resource.
     *
     * @return array
     */
    protected function contactFields()
    {
        return [
            Text::make('Email'),
            Text::make('Mobile'),
            Text::make('Landline')->hideFromIndex(),
            Number::make('QQ', 'qq')->hideFromIndex(),
            Text::make('Wechat')->hideFromIndex(),
            Text::make('Aliwang')->hideFromIndex(),
            Text::make('Address'),
        ];
    }

    /**
     * Get the payment fields for the resource.
     *
     * @return array
     */
    protected function paymentFields()
    {
        return [
            Text::make('Alipay')->hideFromIndex(),
            Markdown::make('Bank'),
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
