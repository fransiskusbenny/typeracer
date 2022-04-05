<?php

use App\Models\Game;
use App\Models\Lounge;
use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('game.{game}', function ($user, Game $game) {
    return [
        'id' => $user->id,
        'name' => $user->name,
        'percentage' => 0,
        'wpm' => 0,
        'accuracy' => 0,
        'finished' => false,
    ];
});

Broadcast::channel('lounge.{lounge}', function ($user, Lounge $lounge) {
    return [
        'id' => $user->id,
        'name' => $user->name,
    ];
});