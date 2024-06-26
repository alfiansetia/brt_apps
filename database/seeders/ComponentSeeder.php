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
            'AC',
            'Air System',
            'Brake',
            'Cooling system',
            'Electrical',
            'Electrical system',
            'Engine',
            'Fire Supression',
            'Front/Rear axel',
            'Fuel and exhaust system',
            'Fuel system',
            'General Maintenance',
            'Gearbox',
            'Hubs and wheels',
            'Karoseri',
            'Nonteknis',
            'Pintu',
            'Propeler shaft',
            'Steering',
            'Suspension',
            'Telematik',
            'Tyre'
        ];

        foreach ($data as $item) {
            Component::create([
                'name' => $item
            ]);
        }
    }
}
