<?php

use App\Enums\GameState;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('games', function (Blueprint $table) {
            $table->id();
            $table->foreignId('lounge_id')->nullable()->index();
            $table->text('text');
            $table->string('state')->default(GameState::waiting->value);
            $table->tinyInteger('users_count')->default(0);
            $table->boolean('solo')->default(false);
            $table->dateTime('started_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('games');
    }
};
