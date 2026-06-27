@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'border-zinc-200 focus:border-red-400 focus:ring-red-400 rounded-2xl shadow-sm']) }}>
