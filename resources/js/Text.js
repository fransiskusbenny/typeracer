import Char from "./Char";

export default class Text {
    constructor(text) {
        this.text = text
        this.chars = text.split('').map((letter, index) => new Char(index, letter));
    }

    words(index = -1) {
        let words = this.text.split(' ');

        return index >= 0 ? words[index] : words;
    }
}