<?php

namespace Database\Seeders;

use App\Models\Dmcr;
use App\Models\DmcrItem;
use App\Models\Unit;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class InsertDmcrSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->command->alert('Start Seeding data from json!..');

        $jsonFile = public_path('dmcr.json');
        $jsonData = json_decode(file_get_contents($jsonFile), true);
        $this->command->warn('Start Collecting data...');
        $groupedData = [];
        foreach ($jsonData as $key => $item) {
            $unit = Unit::where('code', $item['UNIT'])->first();
            if (!$unit) {
                $this->command->error('Unit Not Found on row : ' . $key . ', Unit Code : ' . $item['UNIT']);
                break;
            }
            $key = $item['UNIT'] . '_' . $item['DATE'];
            if (!isset($groupedData[$key])) {
                $groupedData[$key] = [
                    'UNIT'      => $unit,
                    'unit_code' => $item['UNIT'],
                    'unit_id'   => $unit->id,
                    'pool_id'   => 1,
                    'shift'     => 'day',
                    'type'      => 'unschedule',
                    'date'      => $item['DATE'],
                    'start'     => $item['DATE'] . ' 00:00',
                    'finish'    => $item['DATE'] . ' 00:00',
                    'items'     => []
                ];
            }
            $groupedData[$key]['items'][] = [
                'part_name'     => $item['PART_NAME'],
                'part_number'   => $item['PART_NUMBER'],
                'part_qty'      => $item['QTY'],
                'action'        => $item['ACTION'],
                'desc'          => $item['DESC'],
            ];
        }
        $groupedData = array_values($groupedData);
        $this->command->info('Success collecting, Start Insert data to DB...');
        DB::beginTransaction();
        try {
            foreach ($groupedData as $key => $item) {
                // $this->command->warn('proces data ke : ' . $key);
                $dmcr = Dmcr::create([
                    'unit_id'   => $item['unit_id'],
                    'pool_id'   => $item['pool_id'],
                    'shift'     => $item['shift'],
                    'type'      => $item['type'],
                    'date'      => $item['date'],
                    'start'     => $item['start'],
                    'finish'    => $item['finish'],
                ]);
                foreach ($item['items'] as $key2 => $item2) {
                    DmcrItem::create([
                        'dmcr_id'       => $dmcr->id,
                        'part_name'     => $item2['part_name'],
                        'part_number'   => $item2['part_number'],
                        'part_qty'      => $item2['part_qty'],
                        'action'        => $item2['action'],
                        'desc'          => $item2['desc'],
                    ]);
                }
            }
            $this->command->info('Success insert ' . count($groupedData) . ' data!');
            DB::commit();
        } catch (\Throwable $th) {
            $this->command->error('Fatal Error : ' . $th->getMessage());
            DB::rollBack();
        }
    }
}
