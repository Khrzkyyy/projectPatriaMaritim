<?php

namespace App\Http\Livewire\Barang;

use App\Models\Barang;
use App\Models\Kategori;
use Livewire\Component;

class CreateBarang extends Component
{
    public $kategoris, $id_kategori, $nama, $jumlah, $satuan, $resetInputFields;

    protected $listeners = ['createBarang'];

    protected $rules = [
        'id_kategori' => 'required|integer',
        'nama' => 'required|string',
        'jumlah' => 'required|integer',
        'satuan' => 'required|string',
    ];

    public function mount()
    {
        $this->kategoris = Kategori::all();
        $this->resetInputFields();
    }

    public function createBarang()
    {
        $this->validate();

        $existingBarang = Barang::where('nama', ucwords($this->nama))->exists();

        if ($existingBarang) {
            // $this->emit('showToastr', 'Kategori sudah ada di database', 'error');
            $this->emit('existingBarangFailed', 'Barang sudah terdaftar');
            return $this->resetInputFields();
        }
        
        try {
            $created = Barang::create([
                'id_kategori' => $this->id_kategori,
                'nama' => ucwords($this->nama),
                'jumlah' => $this->jumlah,
                'satuan' => strtoupper($this->satuan),
            ]);

            if ($created) {
                $this->emit('refreshTable');
                $this->emit('saveBarangSuccess', 'Barang ditambahkan');
            } else {
                $this->emit('saveBarangFailed', 'Barang gagal ditambahkan');
            }

            $this->resetInputFields();
            $this->resetErrorBag();
        } catch (\Exception $e) {
            $this->emit('saveBarangError', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function resetInputFields()
    {
        $this->id_kategori = '';
        $this->nama = '';
        $this->jumlah = '';
        $this->satuan = '';
    }
    
    public function render()
    {
        return view('livewire.barang.create-barang', [
            'kategoris' => $this->kategoris
        ]);
    }
}
