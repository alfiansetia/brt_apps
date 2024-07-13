<?php

namespace App\Exports;

use App\Models\Dmcr;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStrictNullComparison;
use PhpOffice\PhpSpreadsheet\Shared\Date;
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
            'Time',
            'Description',
            'Action',
            'Component',
            'Part Number',
            'Part Name',
            'Part Qty',
            'Man Powers',
        ];
    }

    public function map($row): array
    {
        static $number = 1;
        $manPowersNames = $row->man_powers->isEmpty()
            ? '' : implode(', ', $row->man_powers->pluck('user.name')->toArray());

        $start = Carbon::createFromFormat('d/m/Y H:i:s', $row->start);
        $finish = Carbon::createFromFormat('d/m/Y H:i:s', $row->finish);
        $diff = $start->diff($finish);
        $totalHours = ($diff->d * 24) + $diff->h;
        $minutes = $diff->i;
        $formattedDiff = sprintf('%02d:%02d', $totalHours, $minutes);

        return [
            $number++,
            $row->date,
            $row->shift,
            $row->unit->code,
            $row->unit->type,
            $row->type,
            Date::dateTimeToExcel($start),
            Date::dateTimeToExcel($finish),
            $formattedDiff,
            $row->desc,
            $row->action,
            $row->component->name ?? '',
            $row->part_number,
            $row->part_name,
            $row->part_qty,
            $manPowersNames,
        ];
    }

    public function columnFormats(): array
    {
        return [
            'A' => NumberFormat::FORMAT_NUMBER,
            'B' => NumberFormat::FORMAT_DATE_DDMMYYYY,
            'G' => NumberFormat::FORMAT_DATE_TIME4,
            'H' => NumberFormat::FORMAT_DATE_TIME4,
            'O' => NumberFormat::FORMAT_NUMBER,
        ];
    }
}
