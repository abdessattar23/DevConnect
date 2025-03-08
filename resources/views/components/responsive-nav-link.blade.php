@props(['active'])

@php
$classes = ($active ?? false)
            ? 'block w-full ps-3 pe-4 py-2 border-l-4 border-vintage-brown text-start text-base font-medium text-vintage-dark bg-vintage-cream focus:outline-none focus:text-vintage-dark transition duration-150 ease-in-out'
            : 'block w-full ps-3 pe-4 py-2 border-l-4 border-transparent text-start text-base font-medium text-vintage-brown hover:text-vintage-dark hover:border-vintage-accent focus:outline-none focus:text-vintage-dark transition duration-150 ease-in-out';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
