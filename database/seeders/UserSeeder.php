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
        User::create([
            'name'          => 'admin',
            'email'         => 'admin@gmail.com',
            'password'      => Hash::make('admin12345'),
            'role'          => 'admin'
        ]);

        User::create([
            'name'          => 'user',
            'email'         => 'user@gmail.com',
            'password'      => Hash::make('user12345'),
            'role'          => 'user'
        ]);
        $pool = Pool::all();

        foreach ($pool as $item) {
            User::factory(50)->create([
                'pool_id' => $item->id
            ]);
        }
    }
}
