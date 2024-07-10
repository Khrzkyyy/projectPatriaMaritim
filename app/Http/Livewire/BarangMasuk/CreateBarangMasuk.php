<?php

namespace App\Http\Livewire\BarangMasuk;

use App\Models\User;
use Livewire\Component;
use App\Models\BarangMasuk;
use App\Models\BarangKeluar;
use Illuminate\Support\Facades\Auth;

class CreateBarangMasuk extends Component
{
    public $users, $barangKeluars, $id_barang_keluar, $tanggal, $resetInputFields, $showButtonFormCreateBarangMasuk = true, $isReadonly = false;

    protected $listeners = ['createBarangMasuk', 'detailBarangMasukSaved', 'refreshComponent'];

    public function refreshComponent()
    {
        $usedIdBarangKeluar = BarangMasuk::pluck('id_barang_keluar')->toArray();
        $this->barangKeluars = BarangKeluar::where('id_user', Auth::id())
        ->whereNotIn('id', $usedIdBarangKeluar)
        ->get();
    }
    
    protected $rules = [
        'id_barang_keluar' => 'required|integer',
        'tanggal' => 'required|date',
    ];

    public function mount()
    {
        $this->barangKeluars = BarangKeluar::all();
        $this->resetInputFields();
        $this->refreshComponent();
    }

    public function createBarangMasuk()
    {
        $this->validate();
        
        try {
            $created = BarangMasuk::create([
                'id_user' => Auth::id(),
                'id_barang_keluar' => $this->id_barang_keluar,
                'tanggal' => $this->tanggal,
            ]);

            if ($created) {
                $idBarangMasuk = $created->fresh()->id;
                $this->showButtonFormCreateBarangMasuk = false;
                $this->isReadonly = true;
                $this->emit('barangMasukCreated', $idBarangMasuk, $created->id_barang_keluar);
                $this->refreshComponent(); 
            } else {
                $this->emit('saveBarangMasukFailed', 'Pengembalian barang gagal dibuat');
            }

            $this->resetInputFields();
            $this->resetErrorBag();
        } catch (\Exception $e) {
            $this->emit('saveBarangMasukError', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function detailBarangMasukSaved()
    {
        $this->showButtonFormCreateBarangMasuk = true;
        $this->isReadonly = false;
        $this->resetInputFields();
    }

    public function resetInputFields()
    {
        $this->id_barang_keluar = '';
        $this->tanggal = '';
    }
    
    public function render()
    {
        return view('livewire.barang-masuk.create-barang-masuk', [
            'barangKeluars' => $this->barangKeluars
        ]);
    }
}
