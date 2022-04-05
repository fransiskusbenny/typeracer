<div>
    <label class="block text-slate-100" for="name">
        In Game Nickname:
    </label>
    <input type="text"
           name="name"
           class="mt-1 w-full px-4 py-2 bg-slate-700 border text-white rounded-lg text-white focus:outline-none border-slate-600 focus:ring-teal-500 focus:border-teal-500"
           placeholder="Enter your nickname"
           wire:model.debounce.1000ms="name"
    >

</div>
