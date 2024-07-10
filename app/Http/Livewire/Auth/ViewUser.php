<?php

namespace App\Http\Livewire\Auth;

use App\Models\User;
use Livewire\Component;
use App\Exports\ExportUser;
use Livewire\WithPagination;
use Maatwebsite\Excel\Facades\Excel;

class ViewUser extends Component
{
    use WithPagination;

    protected $listeners = ['refreshTable' => '$refresh', 'deleteUser'];

    public function openModalEditUser($idUser)
    {
        $this->emit('editUser', $idUser);
    }
    
    public function deleteUser($idUser)
    {
        $user = User::find($idUser);

        if ($user) {
            $user->delete();
            $this->emit('refreshTable');
            $this->emit('deleteUserSuccess', 'User dihapus');
        } else {
            $this->emit('deleteUserFailed', 'User gagal dihapus');
        }
    }

    public function exportUser()
    {
        return Excel::download(new ExportUser, 'Laporan User.xlsx');
    }
    
    public function render()
    {
        $users = User::orderby('nama', 'asc')->paginate(5);
        return view('livewire.auth.view-user', ['users' => $users]);
    }
}
