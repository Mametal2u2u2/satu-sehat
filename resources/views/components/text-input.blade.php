@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'border-gray-200 focus:border-emerald-500 focus:ring-emerald-500 focus:ring-1 rounded-xl shadow-sm']) }}>

