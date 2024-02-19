@props(['disabled' => false])

<input {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge(['class' => 'border-gray-300 focus:border-[#0490b3c7] focus:ring-[#0490b3c7] rounded-md shadow-sm']) !!}>
