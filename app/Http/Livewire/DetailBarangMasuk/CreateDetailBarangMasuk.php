<?php

namespace App\Http\Livewire\DetailBarangMasuk;

use App\Models\Barang;
use Livewire\Component;
use App\Models\BarangMasuk;
use App\Models\DetailBarangKeluar;
use App\Models\DetailBarangMasuk;

class CreateDetailBarangMasuk extends Component
{
    public $rows = [
        ['id_barang' => '', 'jumlah' => ''],
        ];
    
    public $id_barang_masuk, $barangs, $resetInputFields, $id_barang_keluar, $showFormCreateDetailBarangMasuk = false, $isReadonly = false;

    protected $rules = [
        'id_barang_masuk' => 'required|integer',
        'rows.*.id_barang' => 'required|exists:barangs,id',
        'rows.*.jumlah' => 'required|integer',
    ];

    protected $listeners = [
        'barangMasukCreated' => 'handleBarangMasukCreated',
        'createDetailBarangMasuk'];

    public function handleBarangMasukCreated($idBarangMasuk, $idBarangKeluar)
    {
        $this->id_barang_masuk = $idBarangMasuk;
        $this->id_barang_keluar = $idBarangKeluar;
        $this->resetInputFields();
        $this->barangKeluarSelected();
        $this->showFormCreateDetailBarangMasuk = true;
    }

    public function mount()
    {
        $this->barangs = Barang::all();
        // $this->isReadonly = true;
    }

    public function barangKeluarSelected()
    {
        $detailBarangKeluar = DetailBarangKeluar::where('id_barang_keluar', $this->id_barang_keluar)->get();
        $this->rows = [];

        foreach ($detailBarangKeluar as $detail) {
            $this->rows[] = [
                'id_barang' => $detail->id_barang,
                'jumlah' => $detail->jumlah,
            ];
        }
    }

    public function createDetailBarangMasuk()
    {
        try {
            // Cek apakah id_barang_masuk sudah ada sebelum validasi dan penyimpanan
            if (!$this->id_barang_masuk) {
                throw new \Exception("ID Barang Masuk belum tersedia.");
            }

            $this->validate();

            foreach ($this->rows as $row) {
                DetailBarangMasuk::create([
                    'id_barang_masuk' => $this->id_barang_masuk,
                    'id_barang' => $row['id_barang'],
                    'jumlah' => $row['jumlah'],
                ]);
            }
        
            $this->emit('saveDetailBarangMasukSuccess', 'Pengembalian barang dibuat');
            $this->emit('refreshTable');
            $this->emit('detailBarangMasukSaved');
            $this->showFormCreateDetailBarangMasuk = false;
            $this->resetInputFields();
            $this->resetErrorBag();
        } catch (\Exception $e) {
            $this->emit('saveDetailBarangMasukSuccess', 'Terjadi kesalahan: ' . $e->getMessage());
            BarangMasuk::find($this->id_barang_masuk)->delete();
        }
    }

    public function resetInputFields()
    {
        $this->rows = [
            ['id_barang' => '', 'jumlah' => ''],
        ];
    }
    
    public function render()
    {
        return view('livewire.detail-barang-masuk.create-detail-barang-masuk', [
            'barangs' => $this->barangs
        ]);
    }
}
