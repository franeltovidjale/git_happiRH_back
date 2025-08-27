@props([
'variant' => 'primary',
'size' => 'md',
'type' => 'button',
'href' => null,
'disabled' => false,
'fullWidth' => false
])

@php
$baseClasses = 'inline-flex items-center justify-center font-medium rounded-2xl transition-all duration-200
focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent disabled:opacity-50
disabled:cursor-not-allowed';

// Variants
$variantClasses = match($variant) {
'primary' => 'bg-primary/80 hover:bg-primary text-white focus:ring-primary shadow-lg hover:shadow-xl',
'secondary' => 'bg-secondary/80 hover:bg-secondary text-white focus:ring-secondary',
'outline' => 'border-2 border-primary text-primary hover:bg-primary/10 focus:ring-primary',
'ghost' => 'text-primary hover:bg-primary/10 focus:ring-primary',
'danger' => 'bg-red-500/80 hover:bg-red-500 text-white focus:ring-red-500',
default => 'bg-primary/80 hover:bg-primary text-white focus:ring-primary'
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
