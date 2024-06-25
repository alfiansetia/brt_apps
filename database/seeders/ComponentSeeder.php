<?php

namespace Database\Seeders;

use App\Models\Component;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ComponentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Component::factory(100)->create();
        $data = [
            'Brake',
            'Cooling system',
            'Engine',
            'Suspension',
            'Gearbox',
            'Electrical system',
            'Steering',
            'General Maintenance',
            'Fuel and exhaust system',
            'Hubs and wheels',
            'Air System',
            'Front/Rear axel',
            'Propeler shaft',
            'Pintu',
            'Tyre',
            'Electrical',
            'Karoseri',
            'AC',
            'Suspensi',
            'Telematik',
            'Nonteknis',
            'Fuel system',
        ];
        foreach ($data as $item) {
            Component::create([
                'name' => $item
            ]);
        }
    }
}
