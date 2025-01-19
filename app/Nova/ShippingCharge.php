<?php

namespace App\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\DateTime;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Textarea;
use Laravel\Nova\Http\Requests\NovaRequest;

class ShippingCharge extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var class-string<\App\Models\ShippingCharge>
     */
    public static $model = \App\Models\ShippingCharge::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'title';
    public static $group = 'System';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'title',
    ];

    /**
     * Get the fields displayed by the resource.
     *
     * @param \Laravel\Nova\Http\Requests\NovaRequest $request
     * @return array
     */
    public function fields(NovaRequest $request)
    {
        return [
            ID::make()->sortable(),
//            title
            Text::make('Title', 'title')
                ->sortable()
                ->rules('required', 'max:255')
                ->creationRules('unique:App\Models\ShippingCharge,title')
                ->updateRules('unique:App\Models\ShippingCharge,title,{{resourceId}}')
                ->hideWhenUpdating()
                ->withMeta([
                    'extraAttributes' => [
                        'placeholder' => 'Enter title',
                    ],
                ]),
//            name
            Text::make('Name', 'name')
                ->sortable()
                ->rules('required', 'max:255')
                ->withMeta([
                    'extraAttributes' => [
                        'placeholder' => 'Enter name',
                    ],
                ]),
//            charge
            Number::make('Charge', 'charge')
                ->min(0)
                ->step('any')
                ->rules('required'),
//            des
            Textarea::make('Description', 'description')
                ->sortable()
                ->rules('required')
                ->rows(2)
                ->alwaysShow(),
            //              status
            Select::make('Status', 'active')->options([
                '1' => 'Yes',
                '0' => 'No',
            ])->rules('required')
                ->displayUsing(function ($v) {
                    return $v ? "Active" : "Inactive";
                }),
//            date
            DateTime::make('Created At', 'created_at')
                ->hideFromIndex()
                ->default(now())
                ->hideWhenCreating()
                ->hideWhenUpdating(),

            DateTime::make('Updated At', 'updated_at')
                ->hideFromIndex()
                ->hideWhenCreating()
                ->hideWhenUpdating()
                ->default(now()),
        ];
    }

    /**
     * Get the cards available for the request.
     *
     * @param \Laravel\Nova\Http\Requests\NovaRequest $request
     * @return array
     */
    public function cards(NovaRequest $request)
    {
        return [];
    }

    /**
     * Get the filters available for the resource.
     *
     * @param \Laravel\Nova\Http\Requests\NovaRequest $request
     * @return array
     */
    public function filters(NovaRequest $request)
    {
        return [];
    }

    /**
     * Get the lenses available for the resource.
     *
     * @param \Laravel\Nova\Http\Requests\NovaRequest $request
     * @return array
     */
    public function lenses(NovaRequest $request)
    {
        return [];
    }

    /**
     * Get the actions available for the resource.
     *
     * @param \Laravel\Nova\Http\Requests\NovaRequest $request
     * @return array
     */
    public function actions(NovaRequest $request)
    {
        return [];
    }

    public static function searchable()
    {
        return false;
    }
}
