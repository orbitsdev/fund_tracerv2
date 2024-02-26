@props(['disabled' => false])

<input {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge(['class' => 'bcg  focus:border-[#0490b3c7] focus:ring-[#0490b3c7] rounded-md shadow-sm']) !!}>
