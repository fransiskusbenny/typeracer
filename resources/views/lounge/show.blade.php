<x-layouts.app>
    <header class="mx-auto max-w-7xl py-12 px-8">
        <h1 class="text-5xl font-bold text-slate-50">
            Lounge
        </h1>
        <p class="mt-2 text-lg leading-6 tracking-wide text-slate-300">
            Mingle and play with friends.
        </p>
    </header>
    <div class="mx-auto max-w-7xl px-8">
        @if(session()->has('error'))
        <p class="mb-4 text-red-500 tracking-wide">
            {{ session('error') }}
        </p>
        @endif
        <div class="grid grid-cols-3 gap-x-6">
            <div class="col-span-1">
                <livewire:nickname-input/>
            </div>
            <div class="col-span-1">
               <label class="block text-slate-100" for="name">
                    Invitation URL
                </label>
                <input type="text"
                       name="name"
                       class="mt-1 w-full px-4 py-2 bg-slate-700 border text-white rounded-lg text-white focus:outline-none border-slate-600 cursor-not-allowed"
                       value="{{ route('lounge.show', $lounge) }}"
                       readonly
                >
            </div>
            <div class="col-span-1 flex items-end">
                <form class="w-full" method="post" action="{{ route('lounge.play', $lounge) }}">
                    @csrf
                    <button type="submit" class="w-full inline-flex py-2.5 justify-center text-sm uppercase font-bold bg-teal-700 text-slate-100 rounded-lg">
                         Play Game
                     </button>
                </form>
            </div>
        </div>
       <div class="mt-8">
            <livewire:chatting-lounge :lounge="$lounge"/>
       </div>
    </div>
</x-layouts.app>