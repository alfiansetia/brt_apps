<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStrictNullComparison;

class SpeedExport implements FromArray, WithHeadings, WithMapping, WithStrictNullComparison
{
    protected $data = [];

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function array(): array
    {
        return $this->data['row'];
    }

    public function headings(): array
    {
        return $this->data['column'];
    }

    public function map($row): array
    {
        return $row;
    }
}
