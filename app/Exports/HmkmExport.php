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

    public function __construct($filters)
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
            'Type',
            'Hm Ac',
            'Hm',
            'Km',
            'Description'
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
            $row->hm,
            $row->km,
            $row->hm_ac,
            $row->desc,
        ];
    }

    public function columnFormats(): array
    {
        return [
            'A' => NumberFormat::FORMAT_NUMBER,
            'B' => NumberFormat::FORMAT_DATE_YYYYMMDD,
            'E' => NumberFormat::FORMAT_NUMBER,
            'F' => NumberFormat::FORMAT_NUMBER,
            'G' => NumberFormat::FORMAT_NUMBER,
        ];
    }
}
