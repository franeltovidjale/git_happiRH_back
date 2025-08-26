@props([
'variant' => 'primary',
'size' => 'md',
'type' => 'button',
'href' => null,
'disabled' => false,
'fullWidth' => false
])

@php
$baseClasses = 'inline-flex items-center justify-center font-medium rounded-full transition-all duration-200
focus:outline-none focus:ring-2 focus:ring-offset-2 disabled:opacity-50 disabled:cursor-not-allowed';

// Variants
$variantClasses = match($variant) {
'primary' => 'bg-primary-500 hover:bg-primary-600 text-white focus:ring-primary-500 shadow-lg hover:shadow-xl',
'secondary' => 'bg-secondary-500 hover:bg-secondary-600 text-white focus:ring-secondary-500',
'outline' => 'border-2 border-primary-500 text-primary-500 hover:bg-primary-50 focus:ring-primary-500',
'ghost' => 'text-primary-600 hover:bg-primary-50 focus:ring-primary-500',
'danger' => 'bg-red-500 hover:bg-red-600 text-white focus:ring-red-500',
default => 'bg-primary-500 hover:bg-primary-600 text-white focus:ring-primary-500'
};

// Sizes
$sizeClasses = match($size) {
'sm' => 'px-3 py-1.5 text-sm',
'md' => 'px-4 py-2 text-sm',
'lg' => 'px-6 py-3 text-base',
'xl' => 'px-8 py-4 text-lg',
default => 'px-4 py-2 text-sm'
};

// Full width
$widthClasses = $fullWidth ? 'w-full' : '';

$classes = $baseClasses . ' ' . $variantClasses . ' ' . $sizeClasses . ' ' . $widthClasses;
@endphp

@if($href)
<a href="{{ $href }}" {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
@else
<button type="{{ $type }}" {{ $attributes->merge(['class' => $classes]) }} @if($disabled) disabled @endif>
    {{ $slot }}
</button>
@endif
