<?php

namespace App\Http\Livewire\BarangMasuk;

use Livewire\Component;
use App\Models\BarangMasuk;
use Illuminate\Support\Carbon;
use App\Exports\ExportBarangMasuk;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;

class ViewBarangMasuk extends Component
{
    public $tanggalAwal, $tanggalAkhir, $barangMasuk;
    
    protected $listeners = ['refreshTable' => '$refresh', 'deleteBarangMasuk'];

    public function mount()
    {
        $now = Carbon::now();
        $this->tanggalAwal = $now->startOfMonth()->format('Y-m-d');
        $this->tanggalAkhir = $now->endOfMonth()->format('Y-m-d');
        $this->loadBarangMasuk();
    }

    public function loadBarangMasuk()
    {
        $query = BarangMasuk::with('detailBarangMasuk', 'user')->orderBy('id', 'desc');

        // Filter sesuai role
        if (Auth::user()->role != 'admin') {
            $query->where('id_user', Auth::id());
        }
        
        // Filter sesuai tanggal
        if ($this->tanggalAwal && $this->tanggalAkhir) {
            $query->whereBetween('tanggal', [$this->tanggalAwal, $this->tanggalAkhir]);
        } elseif ($this->tanggalAwal) {
            $query->whereDate('tanggal', '>=', $this->tanggalAwal);
        } elseif ($this->tanggalAkhir) {
            $query->whereDate('tanggal', '<=', $this->tanggalAkhir);
        }

        $this->barangMasuk = $query->get();
    }

    public function deleteBarangMasuk($idBarangMasuk)
    {
        $barangMasuk = BarangMasuk::find($idBarangMasuk);

        if ($barangMasuk) {
            $barangMasuk->delete();
            $idBarangKeluar = $barangMasuk->id_barang_keluar;
            $this->emit('refreshTable');
            $this->emitTo('barang-masuk.create-barang-masuk', 'refreshComponent', $idBarangKeluar);
            $this->emit('deleteBarangMasukSuccess', 'Pengembalian barang dibatalkan');
        } else {
            $this->emit('deleteBarangMasukFailed', 'Pengembalian barang gagal dibatalkan');
        }
    }

    public function exportBarangMasuk()
    {
        $this->loadBarangMasuk();
        return Excel::download(new ExportBarangMasuk($this ->barangMasuk), 'Laporan Pengembalian Barang.xlsx');
    }
    
    public function render()
    {
        $this->loadBarangMasuk();
        return view('livewire.barang-masuk.view-barang-masuk', ['barangMasuks' => $this->barangMasuk]);
    }
}
