<?php

namespace Postare\SimpleMenuManager\Filament\Resources\MenuResource\MenuTypeHandlers;

use Filament\Forms\Components;
use Postare\SimpleMenuManager\Filament\Resources\MenuResource\Traits\CommonFieldsTrait;

class LinkType implements MenuTypeInterface
{
    use CommonFieldsTrait;

    public function getName(): string
    {
        return __('simple-menu-manager::simple-menu-manager.handlers.link.name');
    }

    public static function getFields(): array
    {
        return [
            Components\TextInput::make('url')
                ->label('URL')
                ->required()
                ->columnSpanFull(),
            Components\Section::make(__('simple-menu-manager::simple-menu-manager.common.advanced_settings'))
                ->schema(self::commonLinkFields())
                ->collapsed(),
        ];
    }
}
