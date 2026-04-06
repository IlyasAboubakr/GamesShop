<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-500 hover:to-purple-500 text-white px-5 py-2.5 rounded-xl text-sm font-bold transition-all shadow-lg shadow-indigo-500/25 hover:shadow-indigo-500/50 hover:-translate-y-0.5']) }}>
    {{ $slot }}
</button>
