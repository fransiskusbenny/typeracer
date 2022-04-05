<?php

namespace App\Http\Livewire;

use App\Enums\GameState;
use App\Events\GameProgressUpdated;
use App\Events\GameStateUpdated;
use App\Models\Game;
use App\Models\Lounge;
use Illuminate\Support\Collection;
use Livewire\Component;

class GameBoard extends Component
{
    use HasParticipants;

    public bool $solo = true;
    public bool $started = false;
    public bool $gameOver = false;
    public Game $game;
    public ?Lounge $lounge = null;

    public function mount()
    {
        $this->participants = new Collection();
        $this->findOrCreateGame();
    }

    public function render()
    {
        return view('livewire.game-board', [
            'user' => [
                'id' => $this->user()->id,
                'name' => $this->user()->name
            ],
        ]);
    }

    public function getMillisecondsCountdownProperty(): int|null
    {
         return $this->game->started_at?->diffInMilliseconds(now());
    }

    public function gameStatedUpdated()
    {
        $this->game = $this->game->fresh();

        if ($this->game->isStarted()) {
            $this->started = true;
        }
    }

    public function handleCountdownEnds()
    {
        $this->game->update(['state' => GameState::started]);

        GameStateUpdated::broadcast($this->game);
    }

    public function updateProgress($payload)
    {
        GameProgressUpdated::broadcast($this->game, $this->user()->getAuthIdentifier(), $payload);
    }

    public function getParticipantsRankProperty()
    {
        $formatter = new \NumberFormatter('en_US', \NumberFormatter::ORDINAL);

        return $this->participants
            ->sortBy([
                ['wpm', 'desc'],
                ['accuracy', 'desc']
            ])
            ->mapWithKeys(fn($participant, $position) => [$participant['id'] => $formatter->format($position + 1)])
            ->all();
    }

    public function getListeners()
    {
        return [
            "echo-presence:game.{$this->game->id},here" => 'updateParticipants',
            "echo-presence:game.{$this->game->id},joining" => 'addParticipant',
            "echo-presence:game.{$this->game->id},leaving" => 'removeParticipant',
            "echo-private:game.{$this->game->id},GameStateUpdated" => 'gameStatedUpdated',
            "echo-private:game.{$this->game->id},GameProgressUpdated" => 'updateParticipantsGameProgress',
        ];
    }

    public function updateParticipantsGameProgress($payload)
    {
        $this->participants = $this->participants
            ->map(function ($participant) use ($payload) {
                if ($participant['id'] == $payload['user_id']) {
                    $participant['percentage'] = $payload['percentage'];
                    $participant['finished'] = $participant['percentage'] == 100;
                    $participant['wpm'] = $payload['wpm'];
                    $participant['accuracy'] = $payload['accuracy'];
                }
                return $participant;
            })
            ->values();
    }

    protected function findOrCreateGame()
    {
        $this->game = Game::findAvailable($this->solo, $this->lounge);
    }
}
