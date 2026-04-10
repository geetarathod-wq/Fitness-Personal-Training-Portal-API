<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class RolesAndUsersSeeder extends Seeder
{
    public function run(): void
    {
        // 1️⃣ Create roles
        $trainerRole = Role::firstOrCreate(['name' => 'trainer']);
        $customerRole = Role::firstOrCreate(['name' => 'customer']);

        // 2️⃣ Assign trainer role to existing first user, or create one
        $trainerUser = User::first(); // pick the first user in DB

        if (!$trainerUser) {
            // if no users exist, create default trainer
            $trainerUser = User::create([
                'name' => 'Trainer Admin',
                'email' => 'trainer@example.com',
                'password' => Hash::make('password'), // change after login
            ]);
        }

        $trainerUser->role()->associate($trainerRole);
        $trainerUser->save();

        // 3️⃣ Assign remaining users as customers
        foreach(User::whereNull('role_id')->get() as $user) {
            $user->role()->associate($customerRole);
            $user->save();
        }

        $this->command->info('Roles and user assignments completed!');
    }
}