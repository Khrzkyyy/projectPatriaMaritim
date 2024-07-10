<?php

namespace App\Http\Livewire\DetailBarangKeluar;

use App\Models\Barang;
use Livewire\Component;
use App\Models\BarangKeluar;
use App\Models\DetailBarangKeluar;

class CreateDetailBarangKeluar extends Component
{
    public $rows = [
        ['id_barang' => '', 'jumlah' => ''],
        ];
    
    public $id_barang_keluar, $barangs, $resetInputFields, $showFormCreateDetailBarangKeluar = false;

    protected $rules = [
        'id_barang_keluar' => 'required|integer',
        'rows.*.id_barang' => 'required|exists:barangs,id',
        'rows.*.jumlah' => 'required|integer',
    ];

    protected $listeners = [
        'barangKeluarCreated' => 'handleBarangKeluarCreated',
        'createDetailBarangKeluar'];

    // Menerima id_barang_keluar yang dikirim
    public function handleBarangKeluarCreated($idBarangKeluar)
    {
        $this->id_barang_keluar = $idBarangKeluar;
        $this->resetInputFields();
        $this->showFormCreateDetailBarangKeluar = true;
    }

    public function mount()
    {
        $this->barangs = Barang::all();
    }

    public function createDetailBarangKeluar()
    {
        try {
            // Cek apakah id_barang_keluar sudah ada sebelum validasi dan penyimpanan
            if (!$this->id_barang_keluar) {
                throw new \Exception("ID Barang Keluar belum tersedia.");
            }

            $this->validate();

            foreach ($this->rows as $row) {
                DetailBarangKeluar::create([
                    'id_barang_keluar' => $this->id_barang_keluar,
                    'id_barang' => $row['id_barang'],
                    'jumlah' => $row['jumlah'],
                ]);
            }
        
            $this->emit('saveDetailBarangKeluarSuccess', 'Peminjaman barang dibuat');
            $this->emit('refreshTable');
            $this->showFormCreateDetailBarangKeluar = false;
            $this->emit('openModalSuratPeminjaman', $this->id_barang_keluar);
            $this->resetInputFields();
            $this->resetErrorBag();
            
            $this->emit('detailBarangKeluarSaved');
            // $this->emit('toggleReadonly', false);
        } catch (\Exception $e) {
            $this->emit('saveDetailBarangKeluarError', 'Terjadi kesalahan: ' . $e->getMessage());
            BarangKeluar::find($this->id_barang_keluar)->delete();
        }
    }

    public function addNewRow()
    {
        $this->rows[] = ['id_barang' => '', 'jumlah' => ''];
    }

    public function removeRow($index)
    {
        unset($this->rows[$index]);
        $this->rows = array_values($this->rows); // Re-index array
    }

    public function resetInputFields()
    {
        $this->rows = [
            ['id_barang' => '', 'jumlah' => ''],
        ];
    }
    
    public function render()
    {
        return view('livewire.detail-barang-keluar.create-detail-barang-keluar', [
            'barangs' => $this->barangs
        ]);
    }
}
