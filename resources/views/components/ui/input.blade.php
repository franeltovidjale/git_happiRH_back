@props([
'type' => 'text',
'name' => null,
'id' => null,
'label' => null,
'placeholder' => null,
'required' => false,
'value' => null,
'class' => null,
'disabled' => false,
'rows' => null,
'cols' => null
])

@php
$id = $id ?? $name;
$baseClasses = 'w-full px-4 py-1 bg-gray-100/80 border-none rounded-2xl transition-all duration-200 focus:outline-none
focus:ring-2 focus:ring-primary focus:bg-white disabled:opacity-50 disabled:cursor-not-allowed';
$inputClasses = $class ? $baseClasses . ' ' . $class : $baseClasses;
@endphp

<div>
    @if($label)
    <label for="{{ $id }}" class="block text-sm font-medium text-gray-700 mb-2">
        {{ $label }}
        @if($required)
        <span class="text-red-500">*</span>
        @endif
    </label>
    @endif

    <div class="relative bg-gray-100/80 rounded-2xl p-1.5 focus-within:bg-white transition-all duration-200">
        @if($type === 'textarea')
        <textarea name="{{ $name }}" id="{{ $id }}" placeholder="{{ $placeholder }}" {{ $required ? 'required' : '' }}
            {{ $disabled ? 'disabled' : '' }} {{ $rows ? "rows={$rows}" : '' }} {{ $cols ? "cols={$cols}" : '' }} {{
            $attributes->merge(['class' => 'flex-1 bg-transparent border-none outline-none text-gray-800 placeholder-gray-400 resize-none']) }}
            >{{ $value ?? $slot }}</textarea>
        @else
        <input type="{{ $type }}" name="{{ $name }}" id="{{ $id }}" value="{{ $value }}"
            placeholder="{{ $placeholder }}" {{ $required ? 'required' : '' }} {{ $disabled ? 'disabled' : '' }} {{
            $attributes->merge(['class' =>
        'flex-1 bg-transparent border-none outline-none text-gray-800 placeholder-gray-400']) }}
        >
        @endif
    </div>
</div>
