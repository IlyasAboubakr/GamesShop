@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'w-full bg-white/5 border border-white/10 text-gray-100 placeholder-gray-500 focus:border-indigo-500 focus:ring-indigo-500/30 focus:ring-2 rounded-xl shadow-sm transition-colors']) }}>
