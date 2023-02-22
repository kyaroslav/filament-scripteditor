<?php

namespace Filament\FilamentScripteditor\Forms;

use Closure;
use Filament\Forms\Components\Field;

class ScriptEditor extends Field
{
    public string $view = 'filament-scripteditor::script-editor';

    protected int|Closure|null $height = 300;

    protected array|Closure|null $modes = [];

    public function modes(array|Closure|null $modes): static
    {
        $this->modes = $modes;

        return $this;
    }

    public function height(int|Closure|null $height): static
    {
        $this->height = $height;

        return $this;
    }

    public function getHeight(): ?int
    {
        return $this->evaluate($this->height);
    }

    public function getModes(): ?string
    {
        return json_encode($this->evaluate($this->modes));
    }

    public function getMaxTextSize()
    {
        return config('filament-scripteditor.max-text-size', 1024);
    }

    public function getTheme($type = 'light')
    {
        return config('filament-scripteditor.theme.' . $type, 'default');
    }

}
