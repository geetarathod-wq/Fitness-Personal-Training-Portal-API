<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('plan_exercises', function (Blueprint $table) {
            $table->id();

            $table->foreignId('plan_id')
                ->constrained('plans')
                ->onDelete('cascade');

            $table->foreignId('exercise_id')
                ->constrained('exercises')
                ->onDelete('cascade');

            $table->integer('sets')->default(1);
            $table->integer('reps_min')->default(0);
            $table->integer('reps_max')->default(0);

            $table->timestamps();

            
            $table->unique(['plan_id', 'exercise_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('plan_exercises');
    }
};
