import Text from "./Text";

export default function (text, duration) {
    return {
        text: new Text(text),
        currentWordIndex: 0,
        input: '',
        submittedWords: [],
        typedChars: [],
        timer: false,
        seconds: 0,
        gameOver: false,
        started: this.$wire.entangle('started'),
        finished: this.$wire.entangle('gameOver'),
        duration: duration,
        get wpm() {
            if(this.seconds > 0) {
                return ((this.submittedWords.join('').length / 5) / (this.seconds / 60)).toFixed(0)
            }

            return 0;
        },
        get accuracy() {
            let typedCharsCount = this.typedChars.length

            //Ignore last space if completed.
            if(this.submittedWords.join('').length == this.text.text.length) {
                typedCharsCount--;
            }

            const accuracy =  (this.submittedWords.join('').length / typedCharsCount * 100).toFixed(2)
            return accuracy > 0 ? accuracy : 0
        },
        get hasNextWord() {
            return this.text.words(this.currentWordIndex + 1) != undefined;
        },
        get typo() {
            if(!!this.input) {
                return this.text.chars.filter(char => char.status(this.submittedWords, this.input) == 'typo').length > 0
            }

            return false;
        },
        get progress() {
            let words = this.submittedWords.filter(w => w != ' ')

            let progress = (words.length/this.text.words().length)*100;

            return 1 * progress.toFixed(2)
        },
        init() {
            this.setupGameTimer()
        },

        typing($event) {
            if ($event.data) {
                this.typedChars.push($event.data)
            }

            if ($event.data == ' ') {
                this.submit()
            }
        },

        submit() {
            if (this.text.words(this.currentWordIndex) === this.input.trim()) {
                this.submittedWords.push(this.input.trim())
                this.input = '';
                if (this.hasNextWord) {
                    this.submittedWords.push(' ')
                    this.currentWordIndex++
                } else {
                    this.finished = true
                }
            }
        },

        updateProgress() {
            let payload = {
                percentage: this.progress,
                wpm: this.wpm,
                accuracy: this.accuracy
            }

             this.$wire.call('updateProgress', payload)
        },

        setupGameTimer() {
            let timer = null
            this.$watch('started', value => {
                if (value) {
                    this.$refs.input.focus()
                    timer = setInterval(() => {
                        this.updateProgress()
                        this.seconds++
                        this.duration--
                    }, 1000)
                }
            })

            this.$watch('finished', value => {
                if (value) {
                    this.updateProgress()
                    clearInterval(timer)
                    this.finished = true
                }
            })

            this.$watch('duration', value => {
                if(value <= 0) {
                    clearInterval(timer)
                    this.gameOver = true
                    this.finished = true
                }
            })
        },
    }
}