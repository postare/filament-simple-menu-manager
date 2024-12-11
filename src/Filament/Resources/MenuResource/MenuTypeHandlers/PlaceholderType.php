<?php

namespace Postare\SimpleMenuManager\Filament\Resources\MenuResource\MenuTypeHandlers;

class PlaceholderType implements MenuTypeInterface
{
    public function getName(): string
    {
        return __('simple-menu-manager::simple-menu-manager.handlers.placeholder.name');
    }

    public static function getFields(): array
    {
        return [];
    }
}
