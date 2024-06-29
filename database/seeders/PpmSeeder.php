<?php

namespace Database\Seeders;

use App\Models\Ppm;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PpmSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            'General Check Unit',
            'General Check Turbo',
            'General Check Brake',
            'General Check Unit',
        ];

        foreach ($data as $item) {
            Ppm::create([
                'name' => $item
            ]);
        }
    }
}
