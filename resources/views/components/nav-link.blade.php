@props(['active'])

@php
$classes = ($active ?? false)
            ? 'inline-flex items-center px-1 pt-1 border-b-2 border-blue-100 text-sm font-medium leading-5 focus:outline-none focus:border-blue-200 transition duration-150 ease-in-out'
            : 'inline-flex items-center px-1 pt-1 border-b-2 border-transparent text-sm font-medium leading-5 focus:outline-none focus:text-blue-200 focus:border-blue-200 transition duration-150 ease-in-out';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }} style="color:inherit;">
    {{ $slot }}
</a>
