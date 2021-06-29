<?php

namespace Zhineng\NovaGatekeeper\Resources;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\DateTime;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Resource;

class Permission extends Resource
{
    public static $model = \Zhineng\Gatekeeper\Models\Permission::class;

    public static $title = 'name';

    public static $search = [
        'name',
    ];

    public static $displayInNavigation = false;

    public function fields(Request $request)
    {
        return [
            ID::make(__('ID'), 'id')->sortable(),

            Text::make(__('nova-gatekeeper::resource.permission_name'), 'name')
                ->rules('required', 'string', 'max:64')
                ->creationRules('unique:permissions,name')
                ->updateRules('unique:permissions,name,{{resourceId}}'),

            DateTime::make(__('nova-gatekeeper::resource.creation_date'), 'created_at')
                ->onlyOnDetail(),

            DateTime::make(__('nova-gatekeeper::resource.last_update'), 'updated_at')
                ->exceptOnForms(),
        ];
    }

    public static function label()
    {
        return __('nova-gatekeeper::resource.permissions');
    }

    public static function singularLabel()
    {
        return __('nova-gatekeeper::resource.permission');
    }
}
