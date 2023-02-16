<?php

namespace Filament\FilamentScripteditor;

use Filament\PluginServiceProvider;
use Spatie\LaravelPackageTools\Package;

class FilamentScripteditorServiceProvider extends PluginServiceProvider
{
    public static string $name = 'filament-scripteditor';

    /**
     * @var string[]
     */
    protected array $scripts = [
        'filament-scripteditor' => __DIR__ . '/../dist/scripteditor/jsoneditor.min.js',
    ];

    /**
     * @var string[]
     */
    protected array $styles = [
        'filament-scripteditor' => __DIR__ . '/../dist/scripteditor/jsoneditor.min.css',
    ];

    public function configurePackage(Package $package): void
    {
        $package
            ->name(self::$name)
            ->hasConfigFile()
            ->hasAssets()
            ->hasViews();
    }
}
