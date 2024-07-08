<?php

namespace App\Exports;

use App\Models\Keluhan;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStrictNullComparison;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

class KeluhanExport implements FromQuery, WithHeadings, WithMapping, WithColumnFormatting, WithStrictNullComparison
{
    protected  $filters = [];

    public function __construct($filters = [])
    {
        $this->filters = $filters;
    }
    public function query()
    {
        return Keluhan::query()->filter($this->filters)->with(['unit']);
    }

    public function headings(): array
    {
        return [
            'NO',
            'Date',
            'Name',
            'Unit',
            'Unit Type',
            'KM',
            'Keluhan',
            'Responsible',
            'Status',
            'Activity',
        ];
    }

    public function map($row): array
    {
        static $number = 1;
        return [
            $number++,
            $row->date,
            $row->name,
            $row->unit->code,
            $row->unit->type,
            $row->km,
            $row->keluhan,
            $row->responsible,
            $row->status,
            $row->activity,
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
