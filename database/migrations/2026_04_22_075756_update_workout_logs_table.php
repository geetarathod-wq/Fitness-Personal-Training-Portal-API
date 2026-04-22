<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('workout_logs', function (Blueprint $table) {

            $table->foreignId('plan_id')->nullable()->after('user_id');
            $table->foreignId('exercise_id')->nullable()->after('plan_id');

            $table->integer('sets')->nullable()->after('exercise_id');
            $table->integer('reps')->nullable()->after('sets');
            $table->integer('duration')->nullable()->after('reps');

            $table->text('notes')->nullable()->after('duration');
        });
    }

    public function down(): void
    {
        Schema::table('workout_logs', function (Blueprint $table) {
            $table->dropColumn([
                'plan_id',
                'exercise_id',
                'sets',
                'reps',
                'duration',
                'notes'
            ]);
        });
    }
};