
# Script Editor form input for the Filament package

## Installation

You can install the package via composer:

```bash
composer require kyaroslav/filament-scripteditor
```

```bash
php artisan vendor:publish --tag=filament-scriptditor
```

This command will publish the scriptditor resources

## Usage

```php
[
    \Filament\FilamentScripteditor\Forms\ScriptEditor::make('editor');
]
```
## Options
```php
[
    \Filament\FilamentScripteditor\Forms\ScriptEditor::make('editor')
        ->height(500) // Set height to 500px, default is 300
        ->modes([]);
]
```
## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](https://github.com/spatie/.github/blob/main/CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [Yaroslav Kovalenko](https://github.com/kyaroslav)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
