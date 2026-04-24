<?php

namespace App\Policies;

use App\Models\User;
use App\Models\WorkoutTemplate;
use Illuminate\Auth\Access\Response;

class WorkoutTemplatePolicy
{
    public function viewAny(User $user): bool
    {
        return false;
    }

    public function view(User $user, WorkoutTemplate $workoutTemplate): bool
    {
        return false;
    }

    public function create(User $user): bool
    {
        return false;
    }

    public function update(User $user, WorkoutTemplate $workoutTemplate): bool
    {
        return false;
    }

    public function delete(User $user, WorkoutTemplate $workoutTemplate): bool
    {
        return false;
    }

    public function restore(User $user, WorkoutTemplate $workoutTemplate): bool
    {
        return false;
    }

    public function forceDelete(User $user, WorkoutTemplate $workoutTemplate): bool
    {
        return false;
    }
}
