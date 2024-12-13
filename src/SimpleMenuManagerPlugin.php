<?php

namespace Postare\SimpleMenuManager;

use Filament\Contracts\Plugin;
use Filament\Panel;
use Postare\SimpleMenuManager\Filament\Resources\MenuResource;

class SimpleMenuManagerPlugin implements Plugin
{
    public function getId(): string
    {
        return 'simple-menu-manager';
    }

    public function register(Panel $panel): void
    {
        $panel->resources([
            MenuResource::class,
        ]);
    }

    public function boot(Panel $panel): void
    {
        //
    }

    public static function make(): static
    {
        return app(static::class);
    }

    public static function get(): static
    {
        /** @var static $plugin */
        $plugin = filament(app(static::class)->getId());

        return $plugin;
    }
}
