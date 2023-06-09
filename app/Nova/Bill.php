<?php

namespace App\Nova;

use App\Nova\Actions\BillAction;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\BelongsToMany;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;

class Bill extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var class-string<\App\Models\Bill>
     */
    public static $model = \App\Models\Bill::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'id';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id',
    ];

    /**
     * Get the fields displayed by the resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function fields(NovaRequest $request)
    {
        return [
            ID::make()->sortable(),
            BelongsToMany::make('SparePart','SpareParts',SparePart::class),
            BelongsToMany::make('Service','Services',Service::class),
            BelongsTo::make('Report','Report',Report::class)->onlyOnForms()->nullable(),
            BelongsTo::make('Inspection','inspection',Inspection::class),

            Select::make('price','price')
                ->options(function (){

                    return \App\Models\Service::query()
                        ->select(['price','id'])
//                        ->where('type','=','Changing car tires')
                        ->pluck('price','price');

                }),

//            Select::make('price','price')
//            BelongsTo::make('Inspection','inspection',Inspection::class)
//                ->displayUsing(function($name) {
//
//                $jsonUserData=$name
//                    ->join('services', 'services.id', '=', 'bills.inspection_id')
//                    ->where('inspections.id', '=', $name->id)
////                               ->where('vehicles.client_id', '=', $name->id)
//                    ->select('services.type', 'services.price')
//                    ->get()
//                    ->pluck('type', 'price')
//                ;
//                $userData = json_decode($jsonUserData, true);
//                return array_map(function($item) {
//                    return (array)$item;
//                }, $userData);
//            }),
        ];
    }

    /**
     * Get the cards available for the request.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function cards(NovaRequest $request)
    {
        return [];
    }

    /**
     * Get the filters available for the resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function filters(NovaRequest $request)
    {
        return [];
    }

    /**
     * Get the lenses available for the resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function lenses(NovaRequest $request)
    {
        return [];
    }

    /**
     * Get the actions available for the resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function actions(NovaRequest $request)
    {
        return [ new BillAction()];
    }
//    public static function authorizedToCreate(Request $request): bool
//    {
////        return false;
//    }
}
