@props(['as' => 'button', 'disabled' => false])

@if($as == 'link')
    <a {{ $attributes }} {{ $attributes->merge(['class' => 'px-4 py-2 text-sm uppercase font-bold bg-teal-700 text-slate-100 rounded-lg']) }}>
        {{ $slot }}
    </a>
@else
    <button {{ $attributes }} {{ $attributes->merge(['class' => 'px-4 py-2 text-sm uppercase font-bold bg-teal-700 text-slate-100 rounded-lg hover:bg-teal-600 disabled:cursor-not-allowed disabled:opacity-25 disabled:hover:bg-teal-700']) }}
            @disabled($disabled)
    >
        {{ $slot }}
    </button>
@endif