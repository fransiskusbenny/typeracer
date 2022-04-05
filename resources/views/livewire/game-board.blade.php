<div x-data="game('{{ $game->text }}', {{ $game->duration }})">
    @if($game->isWaiting())
       <x-loader>Waiting Competitors</x-loader>
    @endif
    <div>
        <ul class="divide-y divide-slate-800">
            @foreach($participants as $participant)
                <li class="py-4 space-y-2">
                    <div class="flex justify-between items-end">
                        <span class="text-slate-100">
                            <span>{{ $participant['name'] }}</span>
                            @if($user['id'] == $participant['id'])
                                <span class="ml-2 uppercase font-bold text-xs tracking-wide">(You)</span>
                            @endif
                        </span>
                        <span class="text-center">
                            @if($participant['finished'])
                            <span class="block text-sm font-semibold text-slate-200">
                                {{ $this->participantsRank[$participant['id']] }} place
                            </span>
                            @endif
                            <span class="block font-bold text-slate-100">{{ $participant['wpm'] }} WPM</span>
                        </span>
                    </div>
                    <div class="w-full bg-slate-400 rounded-full h-4">
                        <div class="bg-blue-700 h-4 rounded-full" style="width: {{ $participant['percentage'] }}%"></div>
                    </div>
                </li>
            @endforeach
        </ul>
    </div>
    <div class="py-6 w-full flex justify-center">
        @if($game->isCountdown())
            <div @countdown-ends="$wire.call('handleCountdownEnds')">
                <x-countdown
                        :started="true"
                        :countdown="$this->milliseconds_countdown"
                ></x-countdown>
            </div>
        @endif
        @if($game->isStarted())
        <div class="text-xl text-teal-400 font-semibold">
            <template x-if="!gameOver">
                <span x-text="duration.toString().toMMSS()"></span>
            </template>
            <template x-if="gameOver">
                <span class="uppercase tracking-wider font-bold">Game Over</span>
            </template>
        </div>
        @endif
    </div>

    <template x-if="!finished">
        <div class="w-full border-slate-700 bg-slate-800 text-white px-4 py-8 rounded-lg">
            <div class="text-lg leading-6">
                <template x-for="char in text.chars">
                    <span x-text="char.letter"
                            :class="{
                                'typo': 'text-red-600',
                                'correct': 'text-green-600',
                                null: ''
                            }[char.status(submittedWords, input)]"
                    ></span>
                </template>
            </div>
            <div class="mt-5 w-full">
               <input
                    x-ref="input"
                    x-model="input"
                    type="text"
                    class="w-full px-4 py-2 bg-slate-700 border text-white rounded-lg text-white focus:outline-none"
                    @input="typing($event)"
                    @paste="$event.preventDefault()"
                    :class="[
                        typo ? 'border-red-600 focus:ring-red-500 focus:border-red-500' : 'border-slate-600 focus:ring-teal-500 focus:border-teal-500',
                        !started || finished ? 'cursor-not-allowed disabled:bg-slate-500' : ''
                    ]"
                    :disabled="!started || finished"
                />
            </div>
        </div>
    </template>

    <template x-if="finished">
        <div class="w-full bg-slate-700 text-white px-4 py-8 rounded-lg shadow">
            <div class="grid grid-cols-3 gap-x-6">
                <div class="col-span-1">
                    <h4 class="text-sm uppercase tracking-wide font-semibold text-slate-100">Time</h4>
                     <span class="flex text-2xl font-bold text-teal-400">
                        <span class="inline-flex" x-text="seconds.toString().toMMSS()"></span>
                    </span>
                </div>
                <div class="col-span-1">
                    <h4 class="text-sm uppercase tracking-wide font-semibold text-slate-100">WPM</h4>
                    <span class="flex text-2xl font-bold text-teal-400">
                        <span class="inline-flex" x-text="wpm"></span>
                    </span>
                </div>
                <div class="col-span-1">
                    <h4 class="text-sm uppercase tracking-wide font-semibold text-slate-100">Accuracy</h4>
                    <span class="flex text-2xl font-bold text-teal-400">
                        <span class="inline-flex" x-text="accuracy"></span>
                        <span class="inline-flex">%</span>
                    </span>
                </div>
            </div>
        </div>
    </template>
</div>