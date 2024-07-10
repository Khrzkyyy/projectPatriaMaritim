<?php

namespace App\Http\Livewire\Kategori;

use App\Models\Kategori;
use Livewire\Component;

class CreateKategori extends Component
{
    public $nama;

    protected $listeners = ['createKategori'];

    protected $rules = [
        'nama' => 'required|string',
    ];

    public function mount()
    {
        $this->resetInputFields();
    }

    public function createKategori()
    {
        $this->validate();

        $existingKategori = Kategori::where('nama', ucwords($this->nama))->exists();

        if ($existingKategori) {
            $this->emit('existingKategoriFailed', 'Kategori sudah terdaftar');
            return $this->resetInputFields();
        }

        try {
            $created = Kategori::create([
                'nama' => ucwords($this->nama),
            ]);

            if ($created) {
                $this->emit('refreshTable');
                $this->emit('saveKategoriSuccess', 'Kategori ditambahkan');
            } else {
                $this->emit('saveKategoriFailed', 'Kategori gagal ditambahkan');
            }

            $this->resetInputFields();
            $this->resetErrorBag();
        } catch (\Exception $e) {
            $this->emit('saveKategoriError', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function resetInputFields()
    {
        $this->nama = '';
    }
    
    public function render()
    {
        return view('livewire.kategori.create-kategori');
    }
}
