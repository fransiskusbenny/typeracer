<x-layouts.app>
    <header class="mx-auto max-w-7xl py-12 px-8">
        <h1 class="text-5xl font-bold text-slate-50">
            Race With Friends
        </h1>
    </header>
     <div class="mx-auto max-w-7xl px-8">
        <livewire:game-board :solo="false" :lounge="$lounge"/>
         <div class="mt-6 flex justify-end">
             <x-button as="link" href="{{ route('lounge.show', $lounge) }}">
                 Back to the lounge
             </x-button>
         </div>
    </div>
</x-layouts.app>