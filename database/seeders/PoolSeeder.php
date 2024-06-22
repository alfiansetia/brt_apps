<?php

namespace Database\Seeders;

use App\Models\Pool;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PoolSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $names = [
            'Cijantung',
            'Klender',
            'Perintis',
            'Pinang Ranti',
        ];
        foreach ($names as $item) {
            Pool::create([
                'name' => $item
            ]);
        }
    }
}
