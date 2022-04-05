@props(['as' => 'button', 'disabled' => false])

@if($as == 'link')
    <a href="#" {{ $attributes->merge(['class' => 'px-4 py-2 text-sm uppercase font-bold bg-teal-700 text-slate-100 rounded-lg']) }}>
        {{ $slot }}
    </a>
@else
    <button {{ $attributes }}
            {{ $attributes->merge(['class' => 'px-4 py-2 text-sm uppercase font-bold border border-slate-100 text-slate-100 rounded-lg hover:bg-slate-100 hover:text-slate-800 disabled:cursor-not-allowed disabled:opacity-25 disabled:hover:bg-transparent disabled:hover:text-slate-100']) }}
            @disabled($disabled)
    >
        {{ $slot }}
    </button>
@endif