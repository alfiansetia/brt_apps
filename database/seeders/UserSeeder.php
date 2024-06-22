<?php

namespace Database\Seeders;

use App\Models\Pool;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $pool = Pool::all();
        User::create([
            'name'          => 'admin',
            'email'         => 'admin@gmail.com',
            'password'      => Hash::make('admin12345'),
            'role'          => 'admin',
            'pool_id'       => 2,
        ]);

        User::create([
            'name'          => 'user',
            'email'         => 'user@gmail.com',
            'password'      => Hash::make('user12345'),
            'role'          => 'user',
            'pool_id'       => 2,
        ]);

        // for ($i = 0; $i < 100; $i++) {
        //     User::factory(1)->create([
        //         'pool_id' => $pool->random()->id
        //     ]);
        // }
    }
}
