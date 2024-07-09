<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class HmkmSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $jsonFile = public_path('hmkm.json');
        $jsonData = json_decode(file_get_contents($jsonFile), true);

        foreach ($jsonData as $data) {
            DB::table('hmkms')->insert([
                'unit_id'   => $data['unit_id'],
                'date'      => $data['date'],
                'hm'        => $data['hm'],
                'km'        => $data['km'],
                'hm_ac'     => $data['hm_ac'],
                'desc'      => $data['desc'],
            ]);
        }
    }
}
