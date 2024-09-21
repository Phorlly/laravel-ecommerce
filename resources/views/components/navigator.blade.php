@props(['active', 'as' => 'a'])

@php
    $classes =
        $active ?? false
            ? 'inline-flex items-center px-1 pt-1 font-medium text-blue-600 py-3 md:py-6 dark:text-blue-500 dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-gray-600 transition duration-150 ease-in-out'
            : 'inline-flex items-center px-1 pt-1 font-medium text-gray-500 hover:text-gray-400 py-3 md:py-6 dark:text-gray-400 dark:hover:text-gray-500 dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-gray-600 transition duration-150 ease-in-out';
@endphp

<{{ $as }} {{ $attributes->class($classes . 'flex-shrink-0') }} wire:navigate.hover>{{ $slot }}
    </{{ $as }}>
