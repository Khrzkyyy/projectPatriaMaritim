<div>
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4>Pengembalian List</h4>
                <div class="d-flex align-items-center">
                    <div class="me-2">
                        <input type="date" class="form-control" wire:model="tanggalAwal" />
                    </div>
                    <div class="me-2">
                        <input type="date" class="form-control" wire:model="tanggalAkhir" />
                    </div>
                    @if (Auth::user()->role == 'admin')
                    <h4 wire:click="exportBarangMasuk" class="btn btn-success m-0">Export Excel</h4>
                    @endif
                </div>
            </div>
            <div class="card-body">
                <table class="table table-striped table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                    <thead>
                    <tr class="text-center">
                        <th style="width:160px">No. Peminjaman</th>
                        @if (Auth::user()->role == 'admin')
                        <th>Peminjam</th>
                        @endif
                        <th style="width:140px">Tanggal Pinjam</th>
                        <th style="width:140px">Tanggal Kembali</th>
                        <th>Barang</th>
                        <th style="width:140px">Jumlah</th>
                        @if (Auth::user()->role == 'admin')
                        <th style="width:120px" class="text-center">Aksi</th>
                        @endif
                    </tr>
                    </thead>
                    <tbody>
                        @foreach($barangMasuks as $barangMasuk)
                            @if($barangMasuk->detailBarangMasuk->isEmpty())
                                <tr class="text-center" style="vertical-align: middle;">
                                    <td>PMJ-{{ $barangMasuk->barangKeluar->id }}</td>
                                    @if (Auth::user()->role == 'admin')
                                    <td>{{ ucwords($barangMasuk->user->nama) }}</td>
                                    @endif
                                    <td>{{ \Carbon\Carbon::parse($barangMasuk->barangKeluar->tanggal)->format('d/m/Y') }}</td>
                                    <td>{{ \Carbon\Carbon::parse($barangMasuk->tanggal)->format('d/m/Y') }}</td>
                                    <td colspan="2">Tidak ada detail</td>
                                    <td class="text-center">
                                        <a onclick="confirmDelete('{{ $barangMasuk->id }}')" class="btn btn-danger btn-sm">Batalkan</a>
                                    </td>
                                </tr>
                            @else
                                @foreach($barangMasuk->detailBarangMasuk as $index => $detail)
                                    <tr @if($index == 0) class="parent-row" style="vertical-align: middle;" @endif data-id="{{ $barangMasuk->id }}">
                                        @if($index == 0)
                                            <td rowspan="{{ $barangMasuk->detailBarangMasuk->count() }}" class="text-center">PMJ-{{ $barangMasuk->barangKeluar->id }}</td>
                                            @if (Auth::user()->role == 'admin')
                                            <td rowspan="{{ $barangMasuk->detailBarangMasuk->count() }}" class="text-center">{{ ucwords($barangMasuk->user->nama) }}
                                            </td>
                                            @endif
                                            <td rowspan="{{ $barangMasuk->detailBarangMasuk->count() }}" class="text-center">
                                                {{ \Carbon\Carbon::parse($barangMasuk->barangKeluar->tanggal)->format('d/m/Y') }}
                                            </td>
                                            <td rowspan="{{ $barangMasuk->detailBarangMasuk->count() }}" class="text-center">
                                                {{ \Carbon\Carbon::parse($barangMasuk->tanggal)->format('d/m/Y') }}
                                            </td>
                                        @endif
                                        <td class="text-center">{{ $detail->barang->nama }}</td>
                                        <td class="text-center">{{ $detail->jumlah }} {{ $detail->barang->satuan }}</td>
                                        @if (Auth::user()->role == 'admin')
                                            @if($index == 0)
                                                <td rowspan="{{ $barangMasuk->detailBarangMasuk->count() }}" class="text-center">
                                                    <a onclick="confirmDelete('{{ $barangMasuk->id }}')" class="btn btn-danger btn-sm">Batalkan
                                                    </a>
                                                </td>
                                            @endif
                                        @endif
                                    </tr>
                                @endforeach
                            @endif
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    
    <script>
        document.addEventListener('livewire:load', function () {
            Livewire.on('showModalEditBarangMasuk', () => {
            var modal = new bootstrap.Modal(document.getElementById('modalEditBarangMasuk'));
            modal.show();
            });
        });
        
        function confirmDelete(idBarangMasuk) {
            Swal.fire({
                title: "Anda yakin?",
                text: "Anda yakin ingin membatalkan pengembalian?",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#007bff",
                cancelButtonColor: "#dc3545",
                confirmButtonText: "Ya, batalkan!"
            }).then((result) => {
                if (result.isConfirmed) {
                    Livewire.emit('deleteBarangMasuk', idBarangMasuk);
                    Livewire.on('deleteBarangMasukSuccess', (message) => {
                        Swal.fire({
                            title: "Dibatalkan!",
                            text: message,
                            icon: "success",
                            showConfirmButton: false,
                            timer: 1000,
                        });
                    });
                }
            });
        }
    </script>
</div>