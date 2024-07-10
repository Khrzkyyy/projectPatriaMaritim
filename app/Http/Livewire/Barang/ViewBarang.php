<?php

namespace App\Http\Livewire\Barang;

use App\Models\Barang;
use Livewire\Component;
use Livewire\WithPagination;
use App\Exports\ExportBarang;
use Maatwebsite\Excel\Facades\Excel;

class ViewBarang extends Component
{
    use WithPagination;

    protected $listeners = ['refreshTable' => '$refresh', 'deleteBarang'];

    public function openModalEditBarang($idBarang)
    {
        $this->emit('editBarang', $idBarang);
    }

    public function deleteBarang($idBarang)
    {
        $barang = Barang::find($idBarang);

        if ($barang) {
            $barang->delete();
            $this->emit('refreshTable');
            $this->emit('deleteBarangSuccess', 'Barang dihapus');
        } else {
            $this->emit('deleteBarangFailed', 'Barang gagal dihapus');
        }
    }

    public function exportBarang()
    {
        return Excel::download(new ExportBarang, 'Laporan Barang.xlsx');
    }
    
    public function render()
    {
        $barangs = Barang::orderby('nama', 'asc')->paginate(5);
        return view('livewire.barang.view-barang', ['barangs' => $barangs]);
    }
}
