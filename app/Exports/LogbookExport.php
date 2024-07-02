<?php

namespace App\Exports;

use App\Models\Logbook;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStrictNullComparison;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

class LogbookExport implements FromQuery, WithHeadings, WithMapping, WithColumnFormatting, WithStrictNullComparison
{
    protected  $filters = [];

    public function __construct($filters)
    {
        $this->filters = $filters;
    }
    public function query()
    {
        return Logbook::query()->filter($this->filters)->with(['unit', 'component', 'man_powers.user']);
    }

    public function headings(): array
    {
        return [
            'NO',
            'Date',
            'Unit',
            'Unit Type',
            'Component',
            'Location',
            'Pre',
            'Start',
            'Finish',
            'KM RFU',
            'Problem',
            'Action',
            'Respon',
            'Status',
            'Remark',
            'Man Powers',
        ];
    }

    public function map($row): array
    {
        static $number = 1;
        $manPowersNames = $row->man_powers->isEmpty()
            ? '' : implode(', ', $row->man_powers->pluck('user.name')->toArray());
        return [
            $number++,
            $row->date,
            $row->unit->code,
            $row->unit->type,
            $row->component->name ?? '',
            $row->location,
            $row->pre,
            $row->start,
            $row->finish,
            $row->km_rfu,
            $row->problem,
            $row->action,
            $row->respon,
            $row->status,
            $row->desc,
            $manPowersNames,
        ];
    }

    public function columnFormats(): array
    {
        return [
            'A' => NumberFormat::FORMAT_NUMBER,
            'B' => NumberFormat::FORMAT_DATE_YYYYMMDD,
            'G' => NumberFormat::FORMAT_DATE_TIME3,
            'H' => NumberFormat::FORMAT_DATE_TIME3,
            'I' => NumberFormat::FORMAT_DATE_TIME3,
            'J' => NumberFormat::FORMAT_NUMBER,
        ];
    }
}
