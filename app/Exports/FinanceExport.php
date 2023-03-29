<?php

namespace App\Exports;

use App\Models\Finance;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithDefaultStyles;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use PhpOffice\PhpSpreadsheet\Style\Style;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class FinanceExport
    implements
    FromCollection,
    WithMapping,
    WithColumnFormatting,
    WithHeadings,
    ShouldAutoSize,
    WithStyles,
    WithDefaultStyles

{

    public function collection(): Collection
    {
        return Finance::month();
    }

    public function columnFormats(): array
    {
        return [
            'A' => NumberFormat::FORMAT_DATE_DDMMYYYY,
            'B' => '#,##0_-[$đ]',
            'C' => '#,##0_-[$đ]',
            'D' => '#,##0_-[$đ]',
            'E' => '#,##0_-[$đ]',
        ];

    }

    public function map($row): array
    {
        return [
            $row->day,
            $row->extend,
            $row->invoice,
            $row->payment,
            $row->total,
        ];
    }

    public function headings(): array
    {
        return [
            'Ngày',
            'Tổng thu gia hạn',
            'Tổng thu khác',
            'Tổng chi',
            'Thu chi ngày',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        $sheet->getStyle("A")->getFont()->setBold(true);
        $sheet->getStyle(1)->getFont()->setBold(true);
        $sheet->setTitle("Báo cáo tháng");
    }

    public function defaultStyles(Style $defaultStyle)
    {

    }
}
