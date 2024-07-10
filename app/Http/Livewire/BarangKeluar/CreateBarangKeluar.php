<?php

namespace App\Http\Livewire\BarangKeluar;

use App\Models\User;
use Livewire\Component;
use App\Models\BarangKeluar;
use Illuminate\Support\Facades\Auth;

class CreateBarangKeluar extends Component
{
    public $users, $tanggal, $resetInputFields, $showButtonFormCreateBarangKeluar = true, $isReadonly = false;

    protected $listeners = ['createBarangKeluar', 'detailBarangKeluarSaved'];

    protected $rules = [
        'tanggal' => 'required|date',
    ];

    public function mount()
    {
        $this->resetInputFields();
    }

    public function createBarangKeluar()
    {
        $this->validate();
        
        try {
            $created = BarangKeluar::create([
                'id_user' => Auth::id(),
                'tanggal' => $this->tanggal,
            ]);

            if ($created) {
                $idBarangKeluar = $created->fresh()->id;
                $this->showButtonFormCreateBarangKeluar = false;
                $this->isReadonly = true;
                $this->emit('barangKeluarCreated', $idBarangKeluar); //Mengirim id_barang_keluar ke DetailBarangKeluar
            } else {
                $this->emit('saveBarangKeluarFailed', 'Peminjaman barang gagal dibuat');
            }

            $this->resetErrorBag();
        } catch (\Exception $e) {
            $this->emit('saveBarangKeluarError', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function detailBarangKeluarSaved()
    {
        $this->showButtonFormCreateBarangKeluar = true;
        $this->isReadonly = false;
        $this->resetInputFields();
    }

    public function resetInputFields()
    {
        $this->tanggal = '';
    }
    
    public function render()
    {
        return view('livewire.barang-keluar.create-barang-keluar', [
            'users' => $this->users
        ]);
    }
}
