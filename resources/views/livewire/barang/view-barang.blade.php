<div>
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4>Barang List</h4>
                <div class="d-flex align-items-center">
                    <h4 wire:click="exportBarang" class="btn btn-success m-0">Export Excel</h4>
                </div>
            </div>
            <div class="card-body">
                <table class="table table-striped table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                    <thead>
                    <tr>
                        <th class="text-center" style="width:60px">#</th>
                        <th>Kategori</th>
                        <th>Barang</th>
                        <th class="text-center" style="width:140px">Jumlah</th>
                        <th class="text-center" style="width:140px">Aksi</th>
                    </tr>
                    </thead>
                    <tbody>
                        @foreach($barangs as $index => $barang)
                        <tr data-id="{{ $barang->id }}" style="vertical-align: middle;">
                            <td class="text-center" data-field="id">{{ $index + 1 }}</td>
                            <td data-field="id_kategori">{{ $barang->kategori->nama }}</td>
                            <td data-field="nama">{{ $barang->nama }}</td>
                            <td class="text-center" data-field="jumlah">{{ $barang->jumlah }} {{ $barang->satuan }}</td>
                            {{-- <td class="text-center" data-field="satuan">{{ $barang->satuan }}</td> --}}
                            <td class="text-center">
                                <a wire:click="openModalEditBarang('{{ $barang->id }}')" class="btn btn-warning btn-sm">
                                    Edit
                                </a>
                                <a onclick="confirmDelete('{{ $barang->id }}')" class="btn btn-danger btn-sm">Delete
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
        @if ($barangs->hasPages())
            <nav aria-label="Page navigation example">
                <ul class="pagination justify-content-end">
                    {{-- Previous Page Link --}}
                    <li class="page-item {{ $barangs->onFirstPage() ? 'disabled' : '' }}">
                        <a class="page-link" href="#" wire:click.prevent="previousPage" tabindex="-1" aria-disabled="{{ $barangs->onFirstPage() ? 'true' : 'false' }}">
                            Previous
                        </a>
                    </li>
    
                    {{-- Pagination Elements --}}
                    @foreach ($barangs->getUrlRange(1, $barangs->lastPage()) as $page => $url)
                        <li class="page-item {{ $page == $barangs->currentPage() ? 'active' : '' }}">
                            <a class="page-link" href="#" wire:click.prevent="gotoPage({{ $page }})">{{ $page }}</a>
                        </li>
                    @endforeach
    
                    {{-- Next Page Link --}}
                    <li class="page-item {{ !$barangs->hasMorePages() ? 'disabled' : '' }}">
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
            Livewire.on('showModalEditBarang', () => {
            var modal = new bootstrap.Modal(document.getElementById('modalEditBarang'));
            modal.show();
            });
        });
        
        function confirmDelete(idBarang) {
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
                    Livewire.emit('deleteBarang', idBarang);
                    Livewire.on('deleteBarangSuccess', (message) => {
                        Swal.fire({
                            title: "Dihapus!",
                            text: message,
                            icon: "success",
                            showConfirmButton: false,
                            timer: 800,
                        });
                    });

                    Livewire.on('deleteBarangFailed', (message) => {
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