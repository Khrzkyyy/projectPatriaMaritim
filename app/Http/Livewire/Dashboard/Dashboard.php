<?php

namespace App\Http\Livewire\Dashboard;

use App\Models\Barang;
use App\Models\BarangKeluar;
use App\Models\BarangMasuk;
use Livewire\Component;

class Dashboard extends Component
{
    public $barangs, $barangKeluars;

    public function mount()
    {
        // Ambil semua id_barang_keluar yang sudah ada di barang_masuk
        $usedIdBarangKeluar = BarangMasuk::pluck('id_barang_keluar')->toArray();

        // Ambil semua barangKeluar yang id-nya tidak ada di usedIdBarangKeluar
        $this->barangKeluars = BarangKeluar::with('detailBarangKeluar', 'user')
            ->whereNotIn('id', $usedIdBarangKeluar)
            ->orderBy('id', 'desc')
            ->get();

        $this->barangs = Barang::orderBy('nama', 'asc')->get();
    }

    public function render()
    {
        return view('livewire.dashboard.dashboard', [
            'barangs' => $this->barangs,
            'barangKeluars' => $this->barangKeluars,
        ]);
    }
}

