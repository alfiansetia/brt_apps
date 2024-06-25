<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Product::factory(50)->create();
        $data = [
            [
                'name'  => 'Scania Coolant',
                'code'  => 'P0001',
                'type'  => 'coolant',
            ], [
                'name'  => 'Oli Mesin',
                'code'  => 'P0002',
                'type'  => 'oil',
            ], [
                'name'  => 'Oli Differential',
                'code'  => 'P0003',
                'type'  => 'oil',
            ], [
                'name'  => 'Oli Hydraulic',
                'code'  => 'P0004',
                'type'  => 'oil',
            ], [
                'name'  => 'Oli Gearbox',
                'code'  => 'P0005',
                'type'  => 'oil',
            ], [
                'name'  => 'Oli Final Drive',
                'code'  => 'P0006',
                'type'  => 'oil',
            ], [
                'name'  => 'Chemical',
                'code'  => 'P0007',
                'type'  => 'other',
            ],
        ];

        foreach ($data as $item) {
            Product::create($item);
        }
    }
}
