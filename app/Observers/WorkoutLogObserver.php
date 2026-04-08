<?php

namespace App\Observers;

use App\Models\WorkoutLog;

class WorkoutLogObserver
{
    /**
     * Handle the WorkoutLog "created" event.
     */
    public function created(WorkoutLog $workoutLog): void
    {
        //
    }

    /**
     * Handle the WorkoutLog "updated" event.
     */
    public function updated(WorkoutLog $workoutLog): void
    {
        //
    }

    /**
     * Handle the WorkoutLog "deleted" event.
     */
    public function deleted(WorkoutLog $workoutLog): void
    {
        //
    }

    /**
     * Handle the WorkoutLog "restored" event.
     */
    public function restored(WorkoutLog $workoutLog): void
    {
        //
    }

    /**
     * Handle the WorkoutLog "force deleted" event.
     */
    public function forceDeleted(WorkoutLog $workoutLog): void
    {
        //
    }
}
