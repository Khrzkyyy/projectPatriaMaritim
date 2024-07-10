<?php

namespace App\Exports;

use Illuminate\Support\Carbon;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Style\Border;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;

class ExportBarangKeluar implements FromCollection, WithHeadings, WithCustomStartCell, WithTitle, WithStyles
{
    /**
    * @return \Illuminate\Support\Collection
    */
    protected $barangKeluar;

    public function __construct($barangKeluar)
    {
        $this->barangKeluar = $barangKeluar;
    }

    public function collection()
    {
        $data = [];

        foreach ($this->barangKeluar as $barangKeluar) {
            foreach ($barangKeluar->detailBarangKeluar as $detail) {
                $data[] = [
                    'id_barang_keluar' =>'PMJ-' . $barangKeluar->id,
                    'nama_user' => ucwords($barangKeluar->user->nama),
                    'tanggal' => Carbon::parse($barangKeluar->tanggal)->format('d/m/Y'),
                    'nama_barang' => $detail->barang->nama,
                    'jumlah' => $detail->jumlah . ' ' . $detail->barang->satuan,
                ];
            }
        }

        return collect($data);
    }

    public function headings(): array
    {
        return [
            'No. Peminjaman',
            'Peminjam',
            'Tanggal',
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
        return 'Laporan Peminjaman Barang';
    }

    public function styles(Worksheet $sheet)
    {
        $sheet->mergeCells('A1:E4');
        $sheet->setCellValue('A1', 'Laporan Peminjaman Barang PT. Patria Maritim Perkasa');
        $sheet->getStyle('A1')->getFont()->setBold(true);
        $sheet->getStyle('A1')->getFont()->setSize(16);
        $sheet->getStyle('A1')->getAlignment()->setHorizontal('center');
        $sheet->getStyle('A1')->getAlignment()->setVertical('center');
        $sheet->getStyle('A5:E5')->getFont()->setBold(true);
        $sheet->getStyle('A5:E5')->getAlignment()->setHorizontal('center');

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
        $sheet->getStyle('A6:E' . $lastRow)->getAlignment()->setHorizontal('center');
        $sheet->getStyle('A6:E' . $lastRow)->getAlignment()->setHorizontal('center');

        $sheet->getColumnDimension('A')->setAutoSize(true);
        $sheet->getColumnDimension('B')->setAutoSize(true);
        $sheet->getColumnDimension('C')->setAutoSize(true);
        $sheet->getColumnDimension('D')->setAutoSize(true);
        $sheet->getColumnDimension('E')->setAutoSize(true);
    }
}
