<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class ClientSeeder extends Seeder
{
    public function run(): void
    {
        $total = 10000;
        $chunkSize = 500;

        Role::firstOrCreate(['id' => User::ROLE_TRAINER], ['name' => 'trainer']);
        Role::firstOrCreate(['id' => User::ROLE_CLIENT], ['name' => 'client']);

        $password = Hash::make('password');
        $now = now();
        $faker = \Faker\Factory::create();

        $startIndex = (int) DB::table('users')->max('id') + 1;

        $this->command->info("Seeding {$total} clients starting at id {$startIndex}...");

        for ($offset = 0; $offset < $total; $offset += $chunkSize) {
            $rows = [];
            $batchEnd = min($offset + $chunkSize, $total);

            for ($i = $offset; $i < $batchEnd; $i++) {
                $n = $startIndex + $i;
                $rows[] = [
                    'name'       => $faker->name(),
                    'email'      => "client{$n}@test.local",
                    'password'   => $password,
                    'role_id'    => User::ROLE_CLIENT,
                    'created_at' => $now,
                    'updated_at' => $now,
                ];
            }

            DB::table('users')->insert($rows);
            $this->command->info('  inserted '.$batchEnd.'/'.$total);
        }

        $this->command->info('Done. Login with any client email and password: "password"');
    }
}
