<?php

namespace App\Http\Livewire\Auth;

use App\Models\User;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UpdateUser extends Component
{
    public $user, $idUser, $nama, $no_telp, $password, $password_confirmation, $nama_awal, $no_telp_awal, $password_awal;
    
    protected $listeners = ['editUser'];

    protected $rules = [
        'nama' => 'required|string',
        'no_telp' => 'required|string',
        'password' => 'required|string|min:8',
        'password_confirmation' => 'required|same:password',
    ];

    public function updated($field)
    {
        $this->validateOnly($field);
    }

    public function mount(User $user)
    {
        $this->loadUser($user);
        
    }

    public function editUser($idUser)
    {
        $user = User::findOrFail($idUser);
        $this->loadUser($user);
    }

    public function loadUser(User $user)
    {
        $this->user = $user;
        $this->nama = $user->nama;
        $this->no_telp = $user->no_telp;
        $this->password = '';
        $this->nama_awal = $this->nama;
        $this->no_telp_awal = $this->no_telp;
        $this->password_awal = '';
        $this->emit('showModalEditUser');
    }

    public function updateUser()
    {
        $this->validate();

        try {
            if ($this->nama !== $this->nama_awal | $this->no_telp !== $this->no_telp_awal | $this->password !== $this->password_awal) { // Periksa jika diubah
                $updated = $this->user->update([
                    'nama' => htmlspecialchars($this->nama),
                    'no_telp' => $this->no_telp,
                    'password' => Hash::make($this->password),
                ]);

                if ($updated) {
                    $this->emit('refreshTable');
                    $this->emit('updateUserSuccess', 'User diperbarui');
                } else {
                    $this->emit('updateUserFailed', 'User gagal diperbarui');
                }
            }
            // Jika tidak diubah
            $this->resetErrorBag();
        } catch (\Exception $e) {
            $this->emit('updateUserError', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
    
    public function render()
    {
        return view('livewire.auth.update-user');
    }
}
