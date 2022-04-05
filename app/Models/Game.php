<?php

namespace App\Models;

use App\Enums\GameState;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'state' => GameState::class,
        'solo' => 'boolean',
        'started_at' => 'datetime',
    ];

    protected $appends = [
        'duration'
    ];

    public static function findAvailable($solo = true, ?Lounge $lounge = null)
    {
        return self::query()
            ->where('solo', $solo)
            ->whereIn('state', [GameState::waiting->value, GameState::countdown->value])
            ->when($solo,
                fn($query) => $query->where('users_count', 0),
                fn($query) => $query->where('users_count', '<=', 5)
            )
            ->when($lounge, fn($query) => $query->where('lounge_id', $lounge->id))
            ->firstOr(fn() => self::create([
                'lounge_id' => $lounge?->id,
                'solo' => $solo,
                'text' => 'Word Generator is the perfect tool to create words.',
            ]));
    }

    public function isWaiting(): bool
    {
        return $this->state == GameState::waiting;
    }

    public function isCountdown(): bool
    {
        return $this->state == GameState::countdown;
    }

     public function isStarted(): bool
     {
        return $this->state == GameState::started;
    }

    public function isFinished(): bool
    {
        return $this->state == GameState::finished;
    }

    public function duration(): Attribute
    {
        return Attribute::get(fn() => str_word_count($this->text) * 5);
    }
}
