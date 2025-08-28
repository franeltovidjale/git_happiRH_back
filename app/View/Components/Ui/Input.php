<?php

namespace App\View\Components\Ui;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Input extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        public string $type = 'text',
        public ?string $name = null,
        public ?string $id = null,
        public ?string $label = null,
        public ?string $placeholder = null,
        public bool $required = false,
        public ?string $value = null,
        public ?string $class = null,
        public bool $disabled = false,
        public ?string $rows = null,
        public ?string $cols = null
    ) {
        $this->id = $this->id ?? $this->name;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.ui.input');
    }
}