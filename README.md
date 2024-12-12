# This is my package filament-simple-menu-manager

[![Latest Version on Packagist](https://img.shields.io/packagist/v/postare/filament-simple-menu-manager.svg?style=flat-square)](https://packagist.org/packages/postare/filament-simple-menu-manager)
[![GitHub Tests Action Status](https://img.shields.io/github/actions/workflow/status/postare/filament-simple-menu-manager/run-tests.yml?branch=main&label=tests&style=flat-square)](https://github.com/postare/filament-simple-menu-manager/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/actions/workflow/status/postare/filament-simple-menu-manager/fix-php-code-styling.yml?branch=main&label=code%20style&style=flat-square)](https://github.com/postare/filament-simple-menu-manager/actions?query=workflow%3A"Fix+PHP+code+styling"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/postare/filament-simple-menu-manager.svg?style=flat-square)](https://packagist.org/packages/postare/filament-simple-menu-manager)

This is where your description should go. Limit it to a paragraph or two. Consider adding a small example.

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
        'page' => MenuTypeHandlers\PageType::class,
        'placeholder' => MenuTypeHandlers\PlaceholderType::class,
    ],
];
```

## Contributing

Please see [CONTRIBUTING](.github/CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

-   [Francesco Apruzzese](https://github.com/postare)
-   [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
