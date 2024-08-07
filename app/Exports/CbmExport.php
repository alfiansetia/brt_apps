<?php

namespace App\Exports;

use App\Models\Cbm;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStrictNullComparison;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

class CbmExport implements FromQuery, WithHeadings, WithMapping, WithColumnFormatting, WithStrictNullComparison
{
    protected  $filters = [];

    public function __construct($filters = [])
    {
        $this->filters = $filters;
    }
    public function query()
    {
        return Cbm::query()->filter($this->filters)->with(['unit', 'component']);
    }

    public function headings(): array
    {
        return [
            'NO',
            'Date',
            'Unit',
            'Unit Type',
            'Component',
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
            $row->component->name ?? '',
            $row->km,
            $row->desc,
        ];
    }

    public function columnFormats(): array
    {
        return [
            'A' => NumberFormat::FORMAT_NUMBER,
            'B' => NumberFormat::FORMAT_DATE_DDMMYYYY,
            'F' => NumberFormat::FORMAT_NUMBER,
        ];
    }
}
