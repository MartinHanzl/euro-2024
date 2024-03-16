<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('games', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('home_team_id');
            $table->foreign('home_team_id')
                ->references('id')
                ->on('teams')
                ->onUpdate('CASCADE')
                ->onDelete('CASCADE');

            $table->unsignedBigInteger('away_team_id');
            $table->foreign('away_team_id')
                ->references('id')
                ->on('teams')
                ->onUpdate('CASCADE')
                ->onDelete('CASCADE');

            $table->integer('home_goals')->default(0);
            $table->integer('away_goals')->default(0);

            $table->enum('type', ['group', 'knockout', 'eightfinals', 'quarterfinals', 'semifinals', 'finals']);
            $table->timestamp('start_at')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('matches');
    }
};
