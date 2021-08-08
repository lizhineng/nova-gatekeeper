<?php

namespace Zhineng\NovaGatekeeper;

use Illuminate\Http\Request;
use Laravel\Nova\ResourceCollection;
use Laravel\Nova\Tool;
use Zhineng\NovaGatekeeper\Resources\Permission;
use Zhineng\NovaGatekeeper\Resources\Role;

class NovaGatekeeper extends Tool
{
    /**
     * Perform any tasks that need to happen when the tool is booted.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Build the view that renders the navigation links for the tool.
     *
     * @return \Illuminate\View\View
     */
    public function renderNavigation()
    {
        return view('nova-gatekeeper::navigation', [
            'resources' => static::resourcesForNavigation(request()),
        ]);
    }

    public static function resourcesForNavigation(Request $request)
    {
        return static::authorizedResources($request)
            ->all();
    }

    public static function authorizedResources(Request $request)
    {
        return static::resourceCollection()->authorized($request);
    }

    private static function resourceCollection()
    {
        return ResourceCollection::make(static::resources());
    }

    public static function resources(): array
    {
        return [
            Role::class,
            Permission::class,
        ];
    }
}
