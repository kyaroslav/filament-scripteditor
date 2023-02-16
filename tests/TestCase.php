<?php

namespace Filament\FilamentScripteditor\Tests;

use Filament\FilamentServiceProvider;
use Illuminate\Database\Eloquent\Factories\Factory;
use Filament\FilamentScripteditor\FilamentScripteditorServiceProvider;
use Livewire\LivewireServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;

class TestCase extends Orchestra
{
    protected function setUp(): void
    {
        parent::setUp();

        Factory::guessFactoryNamesUsing(
            fn (string $modelName) => 'Filament\\FilamentScripteditor\\Database\\Factories\\'.class_basename($modelName).'Factory'
        );
    }

    protected function getPackageProviders($app)
    {
        return [
            LivewireServiceProvider::class,
            FilamentServiceProvider::class,
            FilamentScripteditorServiceProvider::class,
        ];
    }

    public function getEnvironmentSetUp($app)
    {
    }
}
