<?php

namespace App\Nova;

use App\Nova\Metrics\NewReport;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\BelongsToMany;
use Laravel\Nova\Fields\HasOne;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Markdown;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;

class Report extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var class-string<\App\Models\Report>
     */
    public static $model = \App\Models\Report::class;

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
            Markdown::make('Description','description')->showOnCreating(),
//            BelongsTo::make('Vehicle','vehicle',Vehicle::class),
            BelongsTo::make('Inspection','inspections',Inspection::class) ->displayUsing(function ($name) {

                $jsonUserData=$name
                    ->join('vehicles', 'vehicles.id', '=', 'inspections.vehicle_id')
                    ->where('inspections.id', '=', $name->id)
//                   ->where('vehicles.client_id', '=', $name->id)
                    ->select('vehicles.brand', 'inspections.name')
                    ->get()
                    ->pluck('brand', 'name')
                ;
                $userData = json_decode($jsonUserData, true);
                return array_map(function($item) {
                    return (array)$item;
                }, $userData);
            }),
            Select::make('Technical','spare_part_id')
                ->options(function (){
                    return \App\Models\User::whereHas('Roles', function($q){
                        $q->where('name', 'Technical');
                    })->pluck('name','id');
                })->onlyOnForms(),

            BelongsToMany::make('SparePart','SpareParts',SparePart::class),
            BelongsToMany::make('Service','Services',Service::class),

//            Text::make('User','user_id')->displayUsing(function ($name){
//                return $name->join('user_report', 'user_report.report_id', '=', 'reports.id')
//                    ->where('reports.id', '=', $name->id)
//                    ->where('reports.Users', '=', $name->user_id)
//
////                   ->where('vehicles.client_id', '=', $name->id)
//                    ->select('user_report.user_id')
//
//                    ->get();
//            }),


            BelongsToMany::make('User','Users',User::class)->displayUsing(function ($name) {

                $jsonUserData=$name
                    ->join('user_role', 'roles.id', '=', 'users.role_id')

                    ->where('users.id', '=', $name->id)
//                   ->where('vehicles.client_id', '=', $name->id)
                    ->select('roles.name', 'users.name')
                    ->get()
                    ->pluck('name','name')
                ;
                $userData = json_decode($jsonUserData, true);
                return array_map(function($item) {
                    return (array)$item;
                }, $userData);
            }),

            HasOne::make('Bill','Bill',Bill::class),
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
        return [new NewReport()];
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
        return [];
    }
//    public static function authorizedToCreate(Request $request): bool
//    {
//        return false;
//    }
}
