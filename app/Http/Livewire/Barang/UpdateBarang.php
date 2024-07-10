<?php

namespace App\Http\Livewire\Barang;

use App\Models\Barang;
use Livewire\Component;
use App\Models\Kategori;

class UpdateBarang extends Component
{
    public $barang, $nama, $jumlah, $satuan, $nama_awal, $jumlah_awal, $satuan_awal;

    protected $listeners = ['editBarang'];

    protected $rules = [
        'nama' => 'required|string',
        'jumlah' => 'required|integer',
        'satuan' => 'required|string',
    ];

    public function mount(Barang $barang)
    {
        $this->loadBarang($barang);
    }

    public function editBarang($idBarang)
    {
        $barang = Barang::findOrFail($idBarang);
        $this->loadBarang($barang);
    }

    public function loadBarang(Barang $barang)
    {
        $this->barang = $barang;
        $this->nama = $barang->nama;
        $this->jumlah = $barang->jumlah;
        $this->satuan = $barang->satuan;
        $this->nama_awal = $this->nama;
        $this->jumlah_awal = $this->jumlah;
        $this->satuan_awal = $this->satuan;
        $this->emit('showModalEditBarang');
    }

    public function updateBarang()
    {
        $this->validate();

        try {
            if ($this->nama !== $this->nama_awal | $this->jumlah !== $this->jumlah_awal | $this->satuan !== $this->satuan_awal) { // Periksa jika diubah
                $updated = $this->barang->update([
                    'nama' => ucwords($this->nama),
                    'jumlah' => $this->jumlah,
                    'satuan' => strtoupper($this->satuan),
                ]);

                if ($updated) {
                    $this->emit('refreshTable');
                    $this->emit('updateBarangSuccess', 'Barang diperbarui');
                } else {
                    $this->emit('updateBarangFailed', 'Barang gagal diperbarui');

                }
            } 
            // Jika tidak diubah
            $this->emit('closeModal');
            $this->resetErrorBag();
        } catch (\Exception $e) {
            $this->emit('updateBarangError', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
    
    public function render()
    {
        return view('livewire.barang.update-barang');
    }
}
