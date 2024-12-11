<?php

namespace Postare\SimpleMenuManager\Filament\Resources\MenuResource\MenuTypeHandlers;

interface MenuTypeInterface
{
    /**
     * Get the name of the menu type.
     * @return string
     */
    public function getName(): string;

    /**
     * Get the fields for the menu type.
     * @return array
     */
    public static function getFields(): array;
}
