@props([
    'started' => false,
    'countdown' => 5000
])
<div
        x-data="{
    countdown: {{ $countdown }},
    init() {
        let timer = setInterval(() => {
            this.countdown -=100
        }, 100)

        this.$watch('countdown', val => {
            if(val/1000 < 1) {
                this.$dispatch('countdown-ends');
                clearInterval(timer)
            }
        })
    }
}"
>

{{--    <template x-if="countdown > 0">--}}
        <h3 class="text-2xl text-slate-100">
            <span class="text-sm uppercase font-semibold tracking-wide">Game Started in</span>
            <span class="font-bold" x-text="(countdown/1000).toFixed(0)"></span>
        </h3>
{{--    </template>--}}
</div>