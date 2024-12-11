<?php

namespace Postare\SimpleMenuManager\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Postare\SimpleMenuManager\SimpleMenuManager
 */
class SimpleMenuManager extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \Postare\SimpleMenuManager\SimpleMenuManager::class;
    }
}
