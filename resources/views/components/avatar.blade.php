@props([
    'name' => '',
    'image' => null,
    'size' => 'md',
    'color' => null
])

@php
$sizes = [
    'xs' => 'avatar-xs',
    'sm' => 'avatar-sm',
    'md' => 'avatar-md',
    'lg' => 'avatar-lg',
    'xl' => 'avatar-xl',
    'xxl' => 'avatar-xxl',
];
$sizeClass = $sizes[$size] ?? '';

// Generate consistent color from name if not provided
$bgColor = $color ?? 'linear-gradient(135deg, #' . substr(md5($name), 0, 6) . ' 0%, #' . substr(md5($name), 6, 6) . ' 100%)';
$initials = mb_substr($name, 0, 2);
@endphp

@if($image)
<img {{ $attributes->merge(['class' => "avatar {$sizeClass}", 'src' => $image, 'alt' => $name]) }}>
@else
<div {{ $attributes->merge(['class' => "avatar {$sizeClass}"]) }} 
     style="background: {{ $bgColor }};">
    {{ $initials }}
</div>
@endif

