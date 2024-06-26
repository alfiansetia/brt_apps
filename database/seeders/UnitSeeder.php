<?php

namespace Database\Seeders;

use App\Models\Pool;
use App\Models\Unit;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UnitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // $pools = Pool::all();
        // for ($i = 0; $i < 200; $i++) {
        //     Unit::factory(1)->create([
        //         'pool_id' => $pools->random()->id
        //     ]);
        // }
        $jsonFile = public_path('unit.json');
        $jsonData = json_decode(file_get_contents($jsonFile), true);

        foreach ($jsonData as $data) {
            Unit::create($data);
        }
    }
}
