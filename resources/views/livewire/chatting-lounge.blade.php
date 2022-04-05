<div class="grid grid-cols-5 gap-x-6" x-data @nickname-updated.window="$wire.call('nicknameUpdated')">
    <div class="col-span-3">
        <h3 class="mb-4 text-xl text-teal-500 font-bold">
            Chats
        </h3>
        <div
                class="bg-slate-500 w-full text-slate-50 px-4 py-2 rounded-lg overflow-y-auto"
                style="height: 300px"
        >
            <ul class="space-y-3">
                @foreach($chats as $chat)
                    @if($chat['user'])
                    <li>
                        <span class="text-teal-500 font-bold">
                            {{ $chat['user']['name'] }}
                        </span>
                        <p>
                            {{ $chat['message'] }}
                        </p>
                    </li>
                    @else
                    <li>
                        <span class="italic font-semibold text-slate-300">
                            {{ $chat['message'] }}
                        </span>
                    </li>
                    @endif
                @endforeach
            </ul>
        </div>
        <div class="mt-4">
            <input
                    type="text"
                    class="w-full px-4 py-2 bg-slate-700 border text-white rounded-lg text-white focus:outline-none border-slate-600 focus:ring-teal-500 focus:border-teal-500"
                    placeholder="Say something..."
                    wire:model="message"
                    wire:keydown.enter="sendMessage"
            />
        </div>
    </div>
    <div class="col-span-2">
        <h3 class="mb-4 text-xl text-teal-500 font-bold">
            Who's here
        </h3>
        <ul class="divide-y divide-slate-700">
            @foreach($participants as $participant)
                <li class="font-semibold text-slate-100 py-2">
                    {{ $participant['name'] }}
                </li>
            @endforeach
        </ul>
    </div>
</div>