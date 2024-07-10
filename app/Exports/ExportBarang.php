<?php

namespace App\Exports;

use App\Models\Barang;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Style\Border;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;

class ExportBarang implements FromCollection, WithHeadings, WithCustomStartCell, WithTitle, WithStyles
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $barangs = Barang::with('kategori')->select('id_kategori', 'nama', 'jumlah', 'satuan')->orderBy('nama', 'asc')->get();
        $barangs = $barangs->map(function ($barang, $index) {
            $barang->id_kategori = $barang->kategori->nama;
            $barang->jumlah = $barang->jumlah . ' ' . $barang->satuan;
            unset($barang->satuan);
            return [
                'No.' => $index + 1,
                'Kategori' => $barang->id_kategori,
                'Barang' => $barang->nama,
                'Jumlah' => $barang->jumlah,
            ];
        });

        return $barangs;
    }
    
    public function headings(): array
    {
        return [
            'No.',
            'Kategori',
            'Barang',
            'Jumlah',
        ];
    }

    public function startCell(): string
    {
        return 'A5'; // Menentukan sel awal untuk data tabel
    }

    public function title(): string
    {
        return 'Laporan Barang';
    }

    public function styles(Worksheet $sheet)
    {
        $sheet->mergeCells('A1:E4');
        $sheet->setCellValue('A1', 'Laporan Barang PT. Jaya Borneo Makmur');
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
