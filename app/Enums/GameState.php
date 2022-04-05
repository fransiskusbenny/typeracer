<?php

namespace App\Enums;

enum GameState: string
{
    case waiting = 'waiting';
    case countdown = 'countdown';
    case started = 'started';
    case finished = 'finished';
}