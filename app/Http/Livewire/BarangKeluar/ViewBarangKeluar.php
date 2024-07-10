<?php

namespace App\Http\Livewire\BarangKeluar;

use Livewire\Component;
use App\Models\BarangKeluar;
use Illuminate\Support\Carbon;
use App\Exports\ExportBarangKeluar;
use App\Models\DetailBarangKeluar;
use App\Models\BarangMasuk;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;

class ViewBarangKeluar extends Component
{
    public $tanggalAwal, $tanggalAkhir, $barangKeluar, $detailBarangKeluar, $selectedBarangKeluar, $selectedBarangKeluarId, $openedSuratPeminjaman = null;
    
    protected $listeners = ['refreshTable' => '$refresh', 'deleteBarangKeluar', 'openModalSuratPeminjaman'];

    public function openModalSuratPeminjaman($idbarangKeluar)
    {
        $this->resetSuratPeminjaman();
        $barangKeluar = BarangKeluar::find($idbarangKeluar);
        
        if ($barangKeluar) {
            $this->selectedBarangKeluarId = $barangKeluar->id;
            $this->openedSuratPeminjaman = $idbarangKeluar;
            
            // Ambil detail barang keluar dengan memuat relasi barang
            $this->detailBarangKeluar = DetailBarangKeluar::where('id_barang_keluar', $idbarangKeluar)
                                        ->with('barang')
                                        ->get()
                                        ->toArray();
            
            $this->selectedBarangKeluar = $barangKeluar; // Jangan konversi ke array
            
            Log::info("Detail BarangKeluar: " . json_encode($this->detailBarangKeluar));
        } else {
            $this->emit('showToastr', 'Peminjaman tidak ditemukan', 'error');
        }
        
        $this->emit('showModalSuratPeminjaman');
    }

    public function resetSuratPeminjaman()
    {
        $this->selectedBarangKeluar = null;
        $this->selectedBarangKeluarId = null;
        $this->openedSuratPeminjaman = null;
    }

    public function closeSuratPeminjaman()
    {
        $this->resetSuratPeminjaman();
        $this->emit('closeModalSuratPeminjaman');
    }
    
    public function mount()
    {
        $now = Carbon::now();
        $this->tanggalAwal = $now->startOfMonth()->format('Y-m-d');
        $this->tanggalAkhir = $now->endOfMonth()->format('Y-m-d');
        $this->loadBarangKeluar();
    }

    public function loadBarangKeluar()
    {
        $query = BarangKeluar::with('detailBarangKeluar', 'user')->orderBy('id', 'desc');

        // Filter sesuai role
        if (Auth::user()->role != 'admin') {
            $usedIdBarangKeluar = BarangMasuk::pluck('id_barang_keluar')->toArray();
            $query->where('id_user', Auth::id())
                ->whereNotIn('id', $usedIdBarangKeluar);
        }

        // Filter sesuai tanggal
        if ($this->tanggalAwal && $this->tanggalAkhir) {
            $query->whereBetween('tanggal', [$this->tanggalAwal, $this->tanggalAkhir]);
        } elseif ($this->tanggalAwal) {
            $query->whereDate('tanggal', '>=', $this->tanggalAwal);
        } elseif ($this->tanggalAkhir) {
            $query->whereDate('tanggal', '<=', $this->tanggalAkhir);
        }

        $this->barangKeluar = $query->get();
    }

    public function refreshComponent()
    {
        $this->loadBarangKeluar();
    }


    public function deleteBarangKeluar($idBarangKeluar)
    {
        $barangKeluar = BarangKeluar::find($idBarangKeluar);

        if ($barangKeluar) {
            $barangKeluar->delete();
            $this->emit('refreshTable');
            $this->emit('deleteBarangKeluarSuccess', 'Peminjaman barang dibatalkan');
        } else {
            $this->emit('deleteBarangKeluarFailed', 'Peminjaman barang gagal dibatalkan');
        }
    }

    public function exportBarangKeluar()
    {
        $this->loadBarangKeluar();
        return Excel::download(new ExportBarangKeluar($this->barangKeluar), 'Laporan Peminjaman Barang.xlsx');
    }
    
    public function render()
    {
        $this->loadBarangKeluar();
        return view('livewire.barang-keluar.view-barang-keluar', ['barangKeluars' => $this->barangKeluar]);
    }
}
