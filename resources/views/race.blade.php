<x-layouts.app>
    <header class="mx-auto max-w-7xl py-12 px-8">
        <h1 class="text-5xl font-bold text-slate-50">Race</h1>
        <p class="mt-2 text-lg leading-6 tracking-wide text-slate-300">
            Race with random people
        </p>
    </header>

    <div class="mx-auto max-w-7xl px-8">
        <livewire:game-board :solo="false"/>
    </div>
</x-layouts.app>