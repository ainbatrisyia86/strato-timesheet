@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge([
    'class' => 'block w-full 
    border-gray-400 
    bg-[#F3F3F3] text-black 
    focus:border-gray-600 
    focus:ring-gray-600 rounded-md 
    shadow-sm'
]) }}>

