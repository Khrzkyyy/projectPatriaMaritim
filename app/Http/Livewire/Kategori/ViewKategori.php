<?php

namespace App\Http\Livewire\Kategori;

use Livewire\Component;
use App\Models\Kategori;
use Livewire\WithPagination;

class ViewKategori extends Component
{
    use WithPagination;

    protected $listeners = ['refreshTable' => '$refresh', 'deleteKategori'];

    public function openModalEditKategori($idKategori)
    {
        $this->emit('editKategori', $idKategori);
    }

    public function deleteKategori($idKategori)
    {
        $kategori = Kategori::find($idKategori);

        if ($kategori) {
            $kategori->delete();
            $this->emit('refreshTable');
            $this->emit('deleteKategoriSuccess', 'Kategori dihapus');
        } else {
            $this->emit('deleteKategoriFailed', 'Kategori gagal dihapus');
        }
    }
    
    public function render()
    {
        $kategoris = Kategori::orderby('nama', 'asc')->paginate(5);
        return view('livewire.kategori.view-kategori', ['kategoris' => $kategoris]);
    }
}
