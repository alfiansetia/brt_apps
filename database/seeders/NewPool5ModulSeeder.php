<?php

namespace Database\Seeders;

use App\Models\Cbm;
use App\Models\Dmcr;
use App\Models\Hmkm;
use App\Models\Keluhan;
use App\Models\OilCoolant;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class NewPool5ModulSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $hmkms = Hmkm::with('unit')->get();
        foreach ($hmkms as $item) {
            $item->update([
                'pool_id' => $item->unit->pool_id,
            ]);
        }
        $oils = OilCoolant::with('unit')->get();
        foreach ($oils as $item) {
            $item->update([
                'pool_id' => $item->unit->pool_id,
            ]);
        }
        $cbms = Cbm::with('unit')->get();
        foreach ($cbms as $item) {
            $item->update([
                'pool_id' => $item->unit->pool_id,
            ]);
        }
        $dmcrs = Dmcr::with('unit')->get();
        foreach ($dmcrs as $item) {
            $item->update([
                'pool_id' => $item->unit->pool_id,
            ]);
        }
        $keluhans = Keluhan::with('unit')->get();
        foreach ($keluhans as $item) {
            $item->update([
                'pool_id' => $item->unit->pool_id,
            ]);
        }
    }
}
