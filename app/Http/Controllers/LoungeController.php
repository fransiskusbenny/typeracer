<?php

namespace App\Http\Controllers;

use App\Events\ChatWasSent;
use App\Models\Lounge;
use Illuminate\Support\Facades\Auth;

class LoungeController
{

    public function show(Lounge $lounge)
    {
        return view('lounge.show', compact('lounge'));
    }

    public function store()
    {
        $lounge = Lounge::create();

        return to_route('lounge.show', $lounge);
    }

    public function play(Lounge $lounge)
    {
//        dd($lounge->currentGame);
        if ($lounge->currentGame?->isStarted()) {
            return to_route('lounge.show', $lounge)->with('error', 'The game has been started. Try again later after the game finished.');
        }

        ChatWasSent::broadcast($lounge, Auth::user()->name. " has entered the game");

        return view('lounge.play', compact('lounge'));
    }
}