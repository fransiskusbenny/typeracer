<x-layouts.app>
    <main class="mx-auto max-w-2xl px-8">
        <div class="min-h-screen flex flex-col justify-center items-center">
            <h1 class="text-5xl text-slate-100 font-bold">Typeracer</h1>
            <p class="mt-4 text-slate-300 tracking-wide text-lg">
                Lorem ipsum dolor sit amet, consectetur adipisicing elit.
            </p>
            <div class="mt-10 max-w-md w-full space-y-5">
                <form method="post" action="/practice">
                    @csrf
                    <button type="submit" class="inline-flex justify-center w-full py-6 uppercase text-lg font-bold tracking-wide bg-blue-700 rounded-lg text-white hover:bg-blue-600 transition ease-in-out hover:-translate-y-1 hover:scale-110 duration-300">
                        Practice
                    </button>
                </form>
                <form method="post" action="/race">
                    @csrf
                    <button type="submit" class="inline-flex justify-center w-full py-6 uppercase text-lg font-bold tracking-wide bg-teal-700 rounded-lg text-white hover:bg-teal-600 transition ease-in-out hover:-translate-y-1 hover:scale-110 duration-300">
                        Race
                    </button>
                </form>
                <form method="post" action="{{ route('lounge.store') }}">
                    @csrf
                    <button type="submit" class="inline-flex justify-center w-full py-6 uppercase text-lg font-bold tracking-wide bg-fuchsia-700 rounded-lg text-white hover:bg-fuchsia-600 transition ease-in-out hover:-translate-y-1 hover:scale-110 duration-300">
                        Race With Friends
                    </button>
                </form>
            </div>
            <div class="w-full max-w-md mt-10">
                <livewire:nickname-input/>
            </div>
        </div>
    </main>
</x-layouts.app>