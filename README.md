# Simple Menu Manager for Filament

![PHP Version](https://img.shields.io/badge/php-%3E%3D8.2-blue)
![License](https://img.shields.io/github/license/postare/filament-simple-menu-manager)

This plugin provides an intuitive and versatile menu manager for your frontends built with **FilamentPHP**. Leveraging **saade/filament-adjacency-list**, it supports tree hierarchies for a clean and organized menu structure. It’s designed to let you easily add and customize any type of menu item you need.

A special thanks to **[awcodes](https://github.com/awcodes)** for inspiring this plugin with their experimental project, **[awcodes/sparky](https://github.com/awcodes/sparky)**. Your work served as a great starting point for creating this flexible menu manager.

### Included Menu Item Types

-   **Link**: a simple customizable link.
-   **Page**: automatically generates a link by selecting a page created with **z3d0x/filament-fabricator**.
-   **Placeholder**: a placeholder, perfect for organizing submenus.

### Extensibility

The plugin is highly extensible. You can quickly and easily create new menu item types using the included dedicated command. This makes it an ideal solution for projects requiring a scalable and customizable menu system.

### Prerequisites

-   PHP >= 8.2
-   Laravel >= 11.x
-   FilamentPHP >= 3.x

## Installation

You can install the package via composer:

```bash
composer require postare/filament-simple-menu-manager
```

You can publish and run the migrations with:

```bash
php artisan vendor:publish --tag="simple-menu-manager-migrations"
php artisan migrate
```

Add the plugin to your list in your `AdminPanelProvider`

```php
->plugins([
    Postare\SimpleMenuManager\SimpleMenuManagerPlugin::make(),
])
```

You can publish the config file with:

```bash
php artisan vendor:publish --tag="simple-menu-manager-config"
```

This is the contents of the published config file:

```php
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

    // Livewire component
    'menu_cache' => 1, // Cache time in seconds, each menu has its own cache
];
```

## Command to Create Custom Handlers

Creating new menu item types is quick and easy thanks to the included dedicated command:

```bash
# Syntax: php artisan make:menu-handler {name} {panel?}

# Example: A menu item for your blog categories
php artisan make:menu-handler BlogCategory
```

Replace `{name}` with the name of your new menu item type.
The command will generate a new handler class that you can customize to suit your specific needs.
If you’re using multiple panels, include the `{panel}` argument to specify the target panel.

### Generated Handler Class

When you use the custom handler command, this is what the generated menu handler class will look like:

```php
namespace App\Filament\SimpleMenu\Handlers;

use Filament\Forms\Components;
use Postare\SimpleMenuManager\Filament\Resources\MenuResource\MenuTypeHandlers\MenuTypeInterface;
use Postare\SimpleMenuManager\Filament\Resources\MenuResource\Traits\CommonFieldsTrait;

class BlogCategoryHandler implements MenuTypeInterface
{
    use CommonFieldsTrait;

    public function getName(): string
    {
        // If necessary, you can modify the name of the menu type
        return "Blog Category";
    }

    public static function getFields(): array
    {
        // Add the necessary fields for your menu type in this array
        return [
            // Components\TextInput::make('url')
            //     ->label('URL')
            //     ->required()
            //     ->columnSpanFull(),

            // Common fields for all menu types
            Components\Section::make(__('simple-menu-manager::simple-menu-manager.common.advanced_settings'))
                ->schema(self::commonLinkFields())
                ->collapsed(),
        ];
    }
}
```

You can add all the fields you need using the familiar and standard FilamentPHP components, giving you full flexibility to tailor your menu items to your project’s requirements.

## Visualizzazione del menu nel frontend

To ensure proper integration, add this line to the content section of your `tailwind.config.js`:

```js
    content: [
        // ...
        "./vendor/postare/filament-simple-menu-manager/resources/views/**/*.blade.php",
    ],
```

### Adding the Livewire Component to Your Page

Don’t forget to specify the menu's slug when adding the Livewire component to your page:

```html
<livewire:simple-menu-manager slug="main-menu" />
```

Below is the structure of the Livewire component:

```php
<div @class([
    'hidden' => !$menu,
])>
    <x-dynamic-component :component="'menus.' . $slug . $variant" :name="$menu->name" :items="$menu->items" />
</div>
```

As you can see, the implementation is straightforward. Thanks to `<x-dynamic-component>`, you have the freedom to create custom menu components tailored to your needs. You can also define different menu variants simply by appending them to the component's name.

#### Component Example

Create the following file structure to define your custom menu:

-   `index.blade.php` in `resources/views/components/menus/main-menu`

```php
@props([
    'name' => null,
    'items' => [],
])

<nav id="main-menu">
    <ul class="flex items-center">
        @foreach ($items as $item)
            <x-menus.main-menu.item :item="$item" />
        @endforeach
    </ul>
</nav>
```

-   `item.blade.php` in `resources/views/components/menus/main-menu`

```php

@props([
    'item' => null,
    'active' => false,
])

@php
    $itemClasses = 'text-xl inline-block w-full px-4 py-2 text-sm text-gray-700 hover:text-black focus:text-black';
@endphp

<li>
    @if (filled($item['children']))
        <x-dropdown>
            <x-slot:trigger>
                <button type="button" {{ $attributes->class([$itemClasses, '' => $active, 'flex items-center gap-2']) }}>
                    <span>{{ $item['label'] }}</span>
                    @svg('heroicon-s-chevron-down', '-me-2 h-3 w-3')
                </button>
            </x-slot>

            <ul class="">
                @foreach ($item['children'] as $child)
                    <x-menus.main-menu.item :item="$child" />
                @endforeach
            </ul>
        </x-dropdown>
    @else
        @if (isset($item['url']))
            <a href="{{ $item['url'] }}" @if ($item['target']) target="{{ $item['target'] }}" @endif @if ($item['rel']) rel="{{ $item['rel'] }}" @endif
                {{ $attributes->class([$itemClasses, '' => active_route($item['url'])]) }}>
                {{ $item['label'] }}
            </a>
        @else
            <span {{ $attributes->class([$itemClasses, '' => $active]) }}>
                {{ $item['label'] }}
            </span>
        @endif
    @endif
</li>
```

-   `dropdown.blade.php` in `resources/views/components/menus`

```php
@props([
    'maxHeight' => null,
    'offset' => 8,
    'placement' => 'bottom-start',
    'shift' => false,
    'teleport' => false,
    'trigger' => null,
    'width' => null,
])

@php
    use Filament\Support\Enums\MaxWidth;
@endphp

<div x-data="{
    submenuOpen: false,
    toggle: function(event) {
        this.submenuOpen = !this.submenuOpen
    },
    open: function(event) {
        this.submenuOpen = true
    },
    close: function(event) {
        this.submenuOpen = false
    },
}" {{ $attributes->class(['dropdown relative']) }}>
    <div x-on:click="toggle" {{ $trigger->attributes->class(['dropdown-trigger flex cursor-pointer']) }}>
        {{ $trigger }}
    </div>
    <div x-cloak @click.outside="submenuOpen = false" x-show="submenuOpen"
        x-float{{ $placement ? ".placement.{$placement}" : '' }}.flip{{ $shift ? '.shift' : '' }}{{ $teleport ? '.teleport' : '' }}{{ $offset ? '.offset' : '' }}="{ offset: {{ $offset }} }" x-ref="panel" x-transition:enter-start="opacity-0"
        x-transition:leave-end="opacity-0" @class([
            'dropdown-panel absolute z-10 w-auto divide-y divide-neutral-100 rounded-lg bg-white shadow-lg ring-1 ring-neutral-950/5 transition',
        ]) @style([
            "max-height: {$maxHeight}" => $maxHeight,
        ])>
        {{ $slot }}
    </div>
</div>
```

### Variants Explained

The Simple Menu Manager supports menu **variants**, allowing you to reuse the same menu structure with different designs or behaviors.

#### How to Use Variants

Pass the `variant` parameter in the Livewire component:

```html
<livewire:menu slug="main-menu" variant="footer" />
```

This tells the system to look for the corresponding Blade file:

`resources/views/components/menus/{slug}/{variant}.blade.php`

## Contributing

Please see [CONTRIBUTING](.github/CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

-   [Francesco Apruzzese](https://github.com/postare)
-   [awcodes](https://github.com/awcodes) for inspiring this plugin with their experimental project [awcodes/sparky](https://github.com/awcodes/sparky).
-   Portions of this code were inspired by or adapted from the open-source community, particularly projects like [saade/filament-adjacency-list](https://github.com/saade/filament-adjacency-list) and [z3d0x/filament-fabricator](https://github.com/z3d0x/filament-fabricator).
-   [FilamentPHP](https://filamentphp.com) for providing the foundational framework and components used in this plugin.

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

```

```
