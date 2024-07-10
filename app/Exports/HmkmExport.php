<?php

namespace App\Exports;

use App\Models\Hmkm;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStrictNullComparison;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

class HmkmExport implements FromQuery, WithHeadings, WithMapping, WithColumnFormatting, WithStrictNullComparison
{
    protected  $filters = [];

    public function __construct($filters = [])
    {
        $this->filters = $filters;
    }
    public function query()
    {
        return Hmkm::query()->filter($this->filters)->with('unit');
    }

    public function headings(): array
    {
        return [
            'NO',
            'Date',
            'Unit',
            'Unit Type',
            'Hm Ac',
            'Hm',
            'Km',
            'Breakpad 1',
            'Breakpad 2',
            'Breakpad 3',
            'Breakpad 4',
            'Breakpad 5',
            'Breakpad 6',
            'Description',
        ];
    }

    public function map($row): array
    {
        static $number = 1;
        return [
            $number++,
            $row->date,
            $row->unit->code,
            $row->unit->type,
            $row->hm_ac,
            $row->hm,
            $row->km,
            $row->breakpad1,
            $row->breakpad2,
            $row->breakpad3,
            $row->breakpad4,
            $row->breakpad5,
            $row->breakpad6,
            $row->desc,
        ];
    }

    public function columnFormats(): array
    {
        return [
            'A' => NumberFormat::FORMAT_NUMBER,
            'B' => NumberFormat::FORMAT_DATE_DDMMYYYY,
            'E' => NumberFormat::FORMAT_NUMBER,
            'F' => NumberFormat::FORMAT_NUMBER,
            'G' => NumberFormat::FORMAT_NUMBER,
            'H' => NumberFormat::FORMAT_NUMBER,
            'I' => NumberFormat::FORMAT_NUMBER,
            'J' => NumberFormat::FORMAT_NUMBER,
            'K' => NumberFormat::FORMAT_NUMBER,
            'L' => NumberFormat::FORMAT_NUMBER,
            'M' => NumberFormat::FORMAT_NUMBER,
        ];
    }
}
