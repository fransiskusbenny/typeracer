export default class Char {
    constructor(index, letter) {
        this.index = index
        this.letter = letter
    }

    status(submittedWords, input) {
        const chars = submittedWords.join('').split('').concat(input.split(''))

        if(!chars[this.index]) {
            return null
        }

        if(chars[this.index] == this.letter) {
            return 'correct'
        }

        return 'typo';
    }
}