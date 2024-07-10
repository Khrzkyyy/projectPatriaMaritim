<div>
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4>User List</h4>
                <div class="d-flex align-items-center">
                    <h4 wire:click="exportUser" class="btn btn-success m-0">Export Excel</h4>
                </div>
            </div>
            <div class="card-body">
                <table class="table table-striped table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                    <thead>
                    <tr>
                        <th class="text-center" style="width:60px">#</th>
                        <th>Nama</th>
                        <th style="width:360px">No. Telpon</th>
                        <th style="width:200px">Role</th>
                        <th class="text-center" style="width:140px">Aksi</th>
                    </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $index => $user)
                        <tr data-id="{{ $user->id }}" style="vertical-align: middle;">
                            <td class="text-center" data-field="id">{{ $index + 1 }}</td>
                            <td data-field="nama">{{ ucwords($user->nama) }}</td>
                            <td data-field="no_telp">{{ $user->no_telp }}</td>
                            <td data-field="role">{{ strtoupper($user->role) }}</td>
                            <td class="text-center">
                                <a wire:click="openModalEditUser('{{ $user->id }}')" class="btn btn-warning btn-sm">
                                    Edit
                                </a>
                                <a onclick="confirmDelete('{{ $user->id }}')" class="btn btn-danger btn-sm">
                                    Delete
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div style="margin-top: 1rem;">
        @if ($users->hasPages())
            <nav aria-label="Page navigation example">
                <ul class="pagination justify-content-end">
                    {{-- Previous Page Link --}}
                    <li class="page-item {{ $users->onFirstPage() ? 'disabled' : '' }}">
                        <a class="page-link" href="#" wire:click.prevent="previousPage" tabindex="-1" aria-disabled="{{ $users->onFirstPage() ? 'true' : 'false' }}">
                            Previous
                        </a>
                    </li>
    
                    {{-- Pagination Elements --}}
                    @foreach ($users->getUrlRange(1, $users->lastPage()) as $page => $url)
                        <li class="page-item {{ $page == $users->currentPage() ? 'active' : '' }}">
                            <a class="page-link" href="#" wire:click.prevent="gotoPage({{ $page }})">{{ $page }}</a>
                        </li>
                    @endforeach
    
                    {{-- Next Page Link --}}
                    <li class="page-item {{ !$users->hasMorePages() ? 'disabled' : '' }}">
                        <a class="page-link" href="#" wire:click.prevent="nextPage">
                            Next
                        </a>
                    </li>
                </ul>
            </nav>
        @endif
    </div>
    
    <script>
        document.addEventListener('livewire:load', function () {
            Livewire.on('showModalEditUser', () => {
            var modal = new bootstrap.Modal(document.getElementById('modalEditUser'));
            modal.show();
            });
        });
        
        function confirmDelete(idUser) {
            Swal.fire({
                title: "Anda yakin?",
                text: "Anda tidak bisa mengembalikan data setelah dihapus!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#007bff",
                cancelButtonColor: "#dc3545",
                confirmButtonText: "Ya, hapus!"
            }).then((result) => {
                if (result.isConfirmed) {
                    Livewire.emit('deleteUser', idUser);
                    Livewire.on('deleteUserSuccess', (message) => {
                        Swal.fire({
                            title: "Dihapus!",
                            text: message,
                            icon: "success",
                            showConfirmButton: false,
                            timer: 800,
                        });
                    });

                    Livewire.on('deleteUserFailed', (message) => {
                        Swal.fire({
                            title: "Gagal!",
                            text: message,
                            icon: "error",
                            showConfirmButton: false,
                            timer: 800,
                        });
                    });
                }
            });
        }
    </script>
</div>