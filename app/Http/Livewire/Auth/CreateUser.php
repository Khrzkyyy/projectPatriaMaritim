<?php

namespace App\Http\Livewire\Auth;

use App\Models\User;
use Livewire\Component;
use Illuminate\Support\Facades\Hash;

class CreateUser extends Component
{
    public $nama, $no_telp, $password, $password_confirmation, $role, $resetInputFields, $showButtonFormCreateUser = true, $isReadonly = false;

    protected $rules = [
        'nama' => 'required|string',
        'no_telp' => 'required|string',
        'password' => 'required|string|min:8',
        'password_confirmation' => 'required|same:password',
        'role' => 'required|in:admin,user',
    ];

    public function validateNama($nama)
    {
        if (empty($nama)) {
            $this->addError('nama', 'Nama harus di isi');
        } elseif (User::where('nama', $nama)->exists()) {
            $this->addError('nama', 'Nama sudah ada di database');
        } else {
            $this->resetErrorBag('nama');
        }
    }

    public function updated($field)
    {
        if ($field === 'nama') {
            $this->validateNama($this->nama);
        } else {
            $this->validateOnly($field);
        }
    }

    public function mount()
    {
        $this->resetInputFields();
    }

    public function createUser()
    {
        $this->validate();

        $existingUser = User::where('nama', $this->nama)->exists();

        if ($existingUser) {
            $this->emit('existingUserFailed', 'User sudah ada di database');
            return $this->resetInputFields();
        }
        
        try {
            $created = User::create([
                'nama' => htmlspecialchars($this->nama),
                'no_telp' =>$this->no_telp,
                'password' => Hash::make($this->password),
                'role' => $this->role,
            ]);

            if ($created) {
                $this->showButtonFormCreateUser = false;
                $this->isReadonly = true;
                $this->emit('refreshTable');
                $this->emit('closeModal');
                $this->emit('saveUserSuccess', 'User dibuat');
            } else {
                $this->emit('saveUserFailed', 'User Gagal dibuat');
            }
            
            $this->emit('closeModal');
            $this->resetErrorBag();
            $this->resetInputFields();
        } catch (\Exception $e) {
            $this->emit('saveUserError', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function resetInputFields()
    {
        $this->nama = '';
        $this->no_telp = '';
        $this->password = '';
        $this->password_confirmation = '';
        $this->role = '';
    }
    
    public function render()
    {
        return view('livewire.auth.create-user');
    }
}
