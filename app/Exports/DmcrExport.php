<?php

namespace App\Exports;

use App\Models\Dmcr;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStrictNullComparison;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

class DmcrExport implements FromQuery, WithHeadings, WithMapping, WithColumnFormatting, WithStrictNullComparison
{
    protected  $filters = [];

    public function __construct($filters = [])
    {
        $this->filters = $filters;
    }
    public function query()
    {
        return Dmcr::query()->filter($this->filters)->with(['unit', 'component', 'man_powers.user']);
    }

    public function headings(): array
    {
        return [
            'NO',
            'Date',
            'Shift',
            'Unit',
            'Unit Type',
            'Type',
            'Start',
            'Finish',
            'Description',
            'Action',
            'Component',
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
            $row->shift,
            $row->unit->code,
            $row->unit->type,
            $row->type,
            $row->start,
            $row->finish,
            $row->desc,
            $row->action,
            $row->component->name ?? '',
            $manPowersNames,
        ];
    }

    public function columnFormats(): array
    {
        return [
            'A' => NumberFormat::FORMAT_NUMBER,
            'B' => NumberFormat::FORMAT_DATE_DDMMYYYY,
            'G' => NumberFormat::FORMAT_DATE_DATETIME,
            'H' => NumberFormat::FORMAT_DATE_DATETIME,
        ];
    }
}
