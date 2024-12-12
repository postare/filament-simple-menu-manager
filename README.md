# Simple Menu Manager for Filament

This plugin provides an intuitive and versatile menu manager for your frontends built with **FilamentPHP**. Leveraging **saade/filament-adjacency-list**, it supports tree hierarchies for a clean and organized menu structure. It’s designed to let you easily add and customize any type of menu item you need.

A special thanks to **[awcodes](https://github.com/awcodes)** for inspiring this plugin with their experimental project, **[awcodes/sparky](https://github.com/awcodes/sparky)**. Your work served as a great starting point for creating this flexible menu manager.

### Included Menu Item Types

-   **Link**: a simple customizable link.
-   **Page**: automatically generates a link by selecting a page created with **z3d0x/filament-fabricator**.
-   **Placeholder**: a placeholder, perfect for organizing submenus.

### Extensibility

The plugin is highly extensible. You can quickly and easily create new menu item types using the included dedicated command. This makes it an ideal solution for projects requiring a scalable and customizable menu system.

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

## No Predefined Views

Currently, this plugin does not include any predefined views, as it aims to provide maximum flexibility in how you manage your menus. Below are some examples of how you can handle your menu data on the frontend. However, feel free to use any approach that best suits your project or preferences.

## Contributing

Please see [CONTRIBUTING](.github/CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

-   [Francesco Apruzzese](https://github.com/postare)
-   [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
