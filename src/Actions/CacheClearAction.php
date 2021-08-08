<?php

namespace Zhineng\NovaGatekeeper\Actions;

use Laravel\Nova\Actions\Action;

class CacheClearAction extends Action
{
    public function handle()
    {
        $gatekeeper = app('gatekeeper');

        $gatekeeper->cache()?->forget($gatekeeper->cacheKey());

        return Action::message(__('nova-gatekeeper::actions.cache_clear.success'));
    }

    public function uriKey()
    {
        return 'gatekeeper-cache-clear';
    }

    public function name()
    {
        return __('nova-gatekeeper::actions.cache_clear.name');
    }
}
