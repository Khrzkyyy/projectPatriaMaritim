<div>
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h4>Kategori List</h4>
            </div>
            <div class="card-body">
                <table class="table table-striped table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                    <thead>
                    <tr>
                        <th class="text-center" style="width:60px">#</th>
                        <th>Kategori</th>
                        <th class="text-center" style="width:140px">Aksi</th>
                    </tr>
                    </thead>
                    <tbody>
                        @foreach($kategoris as $index => $kategori)
                        <tr data-id="{{ $kategori->id }}" style="vertical-align: middle;">
                            <td class="text-center" data-field="id">{{ $index + 1 }}</td>
                            <td data-field="nama">{{ $kategori->nama }}</td>
                            <td class="text-center">
                                <a wire:click="openModalEditKategori('{{ $kategori->id }}')" class="btn btn-warning btn-sm">
                                    Edit</a>
                                <a onclick="confirmDelete('{{ $kategori->id }}')" class="btn btn-danger btn-sm">Delete</a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div style="margin-top: 1rem;">
        @if ($kategoris->hasPages())
            <nav aria-label="Page navigation example">
                <ul class="pagination justify-content-end">
                    {{-- Previous Page Link --}}
                    <li class="page-item {{ $kategoris->onFirstPage() ? 'disabled' : '' }}">
                        <a class="page-link" href="#" wire:click.prevent="previousPage" tabindex="-1" aria-disabled="{{ $kategoris->onFirstPage() ? 'true' : 'false' }}">
                            Previous
                        </a>
                    </li>
    
                    {{-- Pagination Elements --}}
                    @foreach ($kategoris->getUrlRange(1, $kategoris->lastPage()) as $page => $url)
                        <li class="page-item {{ $page == $kategoris->currentPage() ? 'active' : '' }}">
                            <a class="page-link" href="#" wire:click.prevent="gotoPage({{ $page }})">{{ $page }}</a>
                        </li>
                    @endforeach
    
                    {{-- Next Page Link --}}
                    <li class="page-item {{ !$kategoris->hasMorePages() ? 'disabled' : '' }}">
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
            Livewire.on('showModalEditKategori', () => {
            var modal = new bootstrap.Modal(document.getElementById('modalEditKategori'));
            modal.show();
            });
        });
        
        function confirmDelete(idKategori) {
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
                    Livewire.emit('deleteKategori', idKategori);
                    Livewire.on('deleteKategoriSuccess', (message) => {
                        Swal.fire({
                            title: "Dihapus!",
                            text: message,
                            icon: "success",
                            showConfirmButton: false,
                            timer: 800,
                        });
                    });

                    Livewire.on('deleteKategoriFailed', (message) => {
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