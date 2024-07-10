<?php

namespace App\Http\Livewire\Kategori;

use App\Models\Kategori;
use Livewire\Component;

class UpdateKategori extends Component
{
    public $kategori, $nama, $nama_awal;

    protected $listeners = ['editKategori'];

    protected $rules = [
        'nama' => 'required|string',
    ];

    public function mount(Kategori $kategori)
    {
        $this->loadKategori($kategori);
    }

    public function editKategori($idKategori)
    {
        $kategori = Kategori::findOrFail($idKategori);
        $this->loadKategori($kategori);
    }

    public function loadKategori(Kategori $kategori)
    {
        $this->kategori = $kategori;
        $this->nama = $kategori->nama;
        $this->nama_awal = $this->nama;
        $this->emit('showModalEditKategori');
    }

    public function updateKategori()
    {
        $this->validate();

        try {
            if ($this->nama !== $this->nama_awal) { // Periksa jika diubah
                $updated = $this->kategori->update([
                    'nama' => ucwords($this->nama),
                ]);

                if ($updated) {
                    $this->emit('refreshTable');
                    $this->emit('updateKategoriSuccess', 'Kategori diperbarui');
                } else {
                    $this->emit('updateKategoriFailed', 'Kategori gagal diperbarui');

                }
            } 
            // Jika tidak diubah
            $this->emit('closeModal');
            $this->resetErrorBag();
        } catch (\Exception $e) {
            $this->emit('updateKategoriError', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
    
    public function render()
    {
        return view('livewire.kategori.update-kategori');
    }
}
