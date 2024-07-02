<?php

namespace App\Exports;

use App\Models\OilCoolant;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStrictNullComparison;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

class OilCoolantExport implements FromQuery, WithHeadings, WithMapping, WithColumnFormatting, WithStrictNullComparison
{
    protected  $filters = [];

    public function __construct($filters)
    {
        $this->filters = $filters;
    }
    public function query()
    {
        return OilCoolant::query()->filter($this->filters)->with(['user', 'product', 'unit']);
    }

    public function headings(): array
    {
        return [
            'NO',
            'Date',
            'User',
            'Unit',
            'Unit Type',
            'Product',
            'Product Code',
            'Amount',
            'Type',
            'Description'
        ];
    }

    public function map($row): array
    {
        static $number = 1;
        return [
            $number++,
            $row->date,
            $row->user->name ?? '',
            $row->unit->code,
            $row->unit->type,
            $row->product->name,
            $row->product->code,
            $row->amount,
            $row->type,
            $row->desc,
        ];
    }

    public function columnFormats(): array
    {
        return [
            'A' => NumberFormat::FORMAT_NUMBER,
            'B' => NumberFormat::FORMAT_DATE_YYYYMMDD,
            'H' => NumberFormat::FORMAT_NUMBER_00,
        ];
    }
}
