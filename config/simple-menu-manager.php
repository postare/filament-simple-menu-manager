<?php

use Postare\SimpleMenuManager\Filament\Resources\MenuResource\MenuTypeHandlers;

return [
    // Resource configuration
    'navigation_group' => 'CMS',
    'navigation_sort' => 1,
    'model_label' => 'Menu',
    'plural_model_label' => 'Menu',

    // Menu Model
    'model' => Postare\SimpleMenuManager\Models\Menu::class,

    /**
     * Menu Type Handlers
     * Add your custom menu type handlers here.
     * */
    'handlers' => [
        'link' => MenuTypeHandlers\LinkType::class,
        // Uncomment this line if you are using z3d0x/filament-fabricator
        // 'page' => MenuTypeHandlers\PageType::class,
        'placeholder' => MenuTypeHandlers\PlaceholderType::class,
    ],
];
