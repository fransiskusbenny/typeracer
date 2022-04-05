// import Alpine from 'alpinejs'
import Echo from 'laravel-echo';
import game from './game'

document.addEventListener('alpine:init', () => {
    window.Alpine.data('game', game)
})

window.String.prototype.toMMSS = function () {
    return new Date(this * 1000).toISOString().substr(14, 5)
}

window.Pusher = require('pusher-js');
window.Echo = new Echo({
    broadcaster: 'pusher',
    key: process.env.MIX_PUSHER_APP_KEY,
    cluster: process.env.MIX_PUSHER_APP_CLUSTER,
    forceTLS: false,
    wsHost: window.location.hostname,
    wsPort: 6001,
    disableStats: true,
});