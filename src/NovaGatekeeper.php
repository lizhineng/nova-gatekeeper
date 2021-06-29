<?php

namespace Zhineng\NovaGatekeeper;

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
            'resources' => static::resources(),
        ]);
    }

    public static function resources(): array
    {
        return [
            Role::class,
            Permission::class,
        ];
    }
}
