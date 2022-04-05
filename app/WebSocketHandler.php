<?php

namespace App;

use App\Enums\GameState;
use App\Models\Game;
use BeyondCode\LaravelWebSockets\WebSockets\Channels\Channel;
use BeyondCode\LaravelWebSockets\WebSockets\Channels\PresenceChannel;
use BeyondCode\LaravelWebSockets\WebSockets\WebSocketHandler as BaseWebSocketHandler;
use Illuminate\Support\Str;
use Pusher\Pusher;
use Ratchet\ConnectionInterface;
use Ratchet\RFC6455\Messaging\MessageInterface;

class WebSocketHandler extends BaseWebSocketHandler
{
    public function onMessage(ConnectionInterface $connection, MessageInterface $message)
    {

        parent::onMessage($connection, $message);

        collect($this->channelManager->getChannels($connection->app->id))->each(function ($channel) {
            if ($channel instanceof PresenceChannel) {
                if (Str::startsWith($channel->getName(), 'presence-game.')) {
                    $id = Str::after($channel->getName(), '.');
                    $game = Game::find($id);
                    $game->update(['users_count' => count($channel->getUsers())]);
                    if ($game->solo && $game->users_count == 1 && $game->isWaiting()) {
                        $game->update([
                            'state' => GameState::countdown,
                            'started_at' => now()->addSeconds(5)
                        ]);
                    }
                    if (!$game->solo && $game->users_count >= 2 && $game->isWaiting()) {
                        $game->update([
                            'state' => GameState::countdown,
                            'started_at' => now()->addSeconds(10)
                        ]);
                    }
                }
            }
        });
    }

    public function onClose(ConnectionInterface $connection)
    {
        parent::onClose($connection);

        $ids = collect($this->channelManager->getChannels($connection->app->id))
            ->filter(fn(Channel $channel) => Str::startsWith($channel->getName(), 'presence-game'))
            ->map(fn(Channel $channel) => Str::after($channel->getName(), '.'))
            ->all();

        Game::query()
            ->whereIn('state', [GameState::countdown, GameState::started])
            ->whereNotIn('id', $ids)
            ->update(['state' => GameState::finished]);
    }

    /**
     * @throws \Pusher\PusherException
     */
    protected function pusher(): Pusher
    {
        return new Pusher(
            config('broadcasting.connections.pusher.key'),
            config('broadcasting.connections.pusher.secret'),
            config('broadcasting.connections.pusher.app_id'),
            config('broadcasting.connections.pusher.options', [])
        );
    }
}