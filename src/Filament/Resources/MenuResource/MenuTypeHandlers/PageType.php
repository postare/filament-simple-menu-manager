<?php

namespace Postare\SimpleMenuManager\Filament\Resources\MenuResource\MenuTypeHandlers;

use Z3d0X\FilamentFabricator\Models\Page;
use Filament\Forms;
use Filament\Forms\Components;
use Postare\SimpleMenuManager\Filament\Resources\MenuResource\Traits\CommonFieldsTrait;
use Z3d0X\FilamentFabricator\Facades\FilamentFabricator;

class PageType implements MenuTypeInterface
{
    use CommonFieldsTrait;

    public function getName(): string
    {
        return __('simple-menu-manager::simple-menu-manager.handlers.page.name');
    }

    public static function getFields(): array
    {
        return [
            Components\Select::make('parent_id')
                ->label('Pagina')
                ->options(fn() => Page::pluck('title', 'id')->toArray())
                ->required()
                ->dehydrated()
                ->afterStateUpdated(function ($state, Forms\Set $set, Forms\Get $get) {
                    if (! $state) {
                        return;
                    }
                    $page_url = FilamentFabricator::getPageUrlFromId($state);
                    $set('url', $page_url);

                    // Set the label only if it is empty
                    if ($get('label') == null) {

                        $set('label', Page::find($state)->title);
                    }
                })
                ->columnSpanFull(),
            Components\TextInput::make('url')
                ->readOnly()
                ->label('URL')
                ->hidden(fn(Forms\Get $get) => $get('parent_id') == null)
                ->required()
                ->columnSpanFull(),
            Components\Section::make(__('simple-menu-manager::simple-menu-manager.common.advanced_settings'))
                ->schema(self::commonLinkFields())
                ->collapsed(),
        ];
    }
}
