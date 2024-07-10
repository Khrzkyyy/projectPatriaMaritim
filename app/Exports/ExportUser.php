<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Style\Border;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;

class ExportUser implements FromCollection, WithHeadings, WithCustomStartCell, WithTitle, WithStyles
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $users = User::select('nama', 'no_telp', 'role')->orderBy('nama', 'asc')->get();
        $users = $users->map(function ($user, $index) {
            $user->nama = ucwords($user->nama);
            $user->role = strtoupper($user->role);
            return [
                'No.' => $index + 1,
                'Nama' => $user->nama,
                'No. Telepon' => $user->no_telp,
                'Role' => $user->role,
            ];
        });

        return $users;
    }
    
    public function headings(): array
    {
        return [
            'No.',
            'Nama',
            'No. Telepon',
            'Role',
        ];
    }

    public function startCell(): string
    {
        return 'A5'; // Menentukan sel awal untuk data tabel
    }

    public function title(): string
    {
        return 'Laporan User';
    }

    public function styles(Worksheet $sheet)
    {
        $sheet->mergeCells('A1:F4');
        $sheet->setCellValue('A1', 'Laporan User PT. Jaya Borneo Makmur');
        $sheet->getStyle('A1')->getFont()->setBold(true);
        $sheet->getStyle('A1')->getFont()->setSize(16);
        $sheet->getStyle('A1')->getAlignment()->setHorizontal('center');
        $sheet->getStyle('A1')->getAlignment()->setVertical('center');
        $sheet->getStyle('A5:D5')->getFont()->setBold(true);
        $sheet->getStyle('A5:D5')->getAlignment()->setHorizontal('center');

        $borderStyle = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['argb' => '000000'],
                ],
            ],
        ];
    
        $lastRow = $sheet->getHighestRow();
        $lastColumn = $sheet->getHighestColumn();
        $sheet->getStyle('A5:'.$lastColumn.$lastRow)->getFont()->setSize(12);
        $sheet->getStyle('A5:'.$lastColumn.$lastRow)->applyFromArray($borderStyle);
        $sheet->getStyle('A6:D' . $lastRow)->getAlignment()->setHorizontal('center');

        $sheet->getColumnDimension('A')->setAutoSize(true);
        $sheet->getColumnDimension('B')->setAutoSize(true);
        $sheet->getColumnDimension('C')->setAutoSize(true);
        $sheet->getColumnDimension('D')->setAutoSize(true);
    }
}
