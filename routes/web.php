<?php

use App\Http\Controllers\LoungeController;
use App\WebSocketHandler;
use BeyondCode\LaravelWebSockets\Facades\WebSocketsRouter;
use Illuminate\Support\Facades\Route;

WebSocketsRouter::webSocket('/app/{appKey}', WebSocketHandler::class);

Route::get('/', function () {
    return view('welcome');
})->name('welcome');

Route::middleware('auth:broadcast')->group(function () {
    Route::post('practice', function () {
        return view('practice');
    });

    Route::post('race', function () {
        return view('race');
    });

    Route::get('lounge/{lounge:token}', [LoungeController::class, 'show'])->name('lounge.show');
    Route::post('lounge', [LoungeController::class, 'store'])->name('lounge.store');
    Route::post('lounge/{lounge:token}/play', [LoungeController::class, 'play'])->name('lounge.play');
});

