<?php

namespace Zhineng\NovaGatekeeper\Resources;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\BooleanGroup;
use Laravel\Nova\Fields\DateTime;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Resource;
use Zhineng\Gatekeeper\Manager as Gatekeeper;

class Role extends Resource
{
    public static $model = \Zhineng\Gatekeeper\Models\Role::class;

    public static $title = 'name';

    public static $search = [
        'name',
    ];

    public static $displayInNavigation = false;

    public function fields(Request $request)
    {
        return [
            ID::make(__('ID'), 'id')->sortable(),

            Text::make(__('nova-gatekeeper::resource.role_name'), 'name')
                ->rules('required', 'string')
                ->creationRules('unique:roles,name')
                ->updateRules('unique:roles,name,{{resourceId}}'),

            BooleanGroup::make(__('nova-gatekeeper::resource.permissions'), 'permissions')
                ->resolveUsing(fn ($value) => $value->mapWithKeys(fn ($permission) => [$permission->getKey() => true]))
                ->fillUsing(function (NovaRequest $request, Model $model, $attribute, $requestAttribute) {
                    return function () use ($request, $model, $attribute, $requestAttribute) {
                        $permissions = collect(json_decode($request->{$requestAttribute}, true));

                        $model->{$attribute}()->sync($permissions->filter()->keys());
                    };
                })
                ->options(Gatekeeper::getInstance()->permissions()->pluck('name', 'id')),

            DateTime::make(__('nova-gatekeeper::resource.creation_date'), 'created_at')
                ->onlyOnDetail(),

            DateTime::make(__('nova-gatekeeper::resource.last_update'), 'updated_at')
                ->exceptOnForms(),
        ];
    }

    public static function label()
    {
        return __('nova-gatekeeper::resource.roles');
    }

    public static function singularLabel()
    {
        return __('nova-gatekeeper::resource.role');
    }
}
