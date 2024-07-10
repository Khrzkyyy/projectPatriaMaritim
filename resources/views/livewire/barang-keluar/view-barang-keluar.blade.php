<div>
    {{-- surat peminjaman --}}
    <div wire:ignore.self class="modal fade" id="modalSuratPeminjaman" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="modalSuratPeminjamanLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalSuratPeminjamanLabel">Surat Peminjaman : <strong>PMJ-{{ $selectedBarangKeluarId }}</strong></h5>
                    <button type="button" class="btn-close waves-effect" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div>
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="row">
                                                <div class="col-6">
                                                    @if($selectedBarangKeluar)
                                                    <address class="font-size-16">
                                                        <strong>Nama Peminjam :</strong>
                                                        {{ ucwords($selectedBarangKeluar->user->nama) }}<br>
                                                        <strong>Tanggal :</strong>
                                                        {{ \Carbon\Carbon::parse($selectedBarangKeluar->tanggal)->format('d/m/Y') }}<br>
                                                        <br>
                                                    </address>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12">
                                            <div>
                                                <div class="modal-title">
                                                    <h3 class="font-size-16"><strong>Daftar Peminjaman</strong></h3>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="table-responsive">
                                                        <table class="table">
                                                            <thead>
                                                            <tr>
                                                                <td class="text-center" style="width: 550px"><strong>Barang</strong></td>
                                                                <td class="text-center"><strong>Jumlah</strong></td>
                                                            </tr>
                                                            </thead>
                                                            <tbody>
                                                                @if(isset($selectedBarangKeluar) && !empty($detailBarangKeluar))
                                                                    @foreach($detailBarangKeluar as $detail)
                                                                        <tr>
                                                                            <td class="text-center">{{ $detail['barang']['nama'] }}</td>
                                                                            <td class="text-center">{{ $detail['jumlah'] }} {{ $detail['barang']['satuan'] }}</td>
                                                                        </tr>
                                                                    @endforeach
                                                                @else
                                                                    <tr>
                                                                        <td colspan="2" class="text-center">No data available</td>
                                                                    </tr>
                                                                @endif
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                                <div class="text-end">
                                                    {{-- <div class="float-end"> --}}
                                                        <a href="javascript:window.print()" class="btn btn-success waves-effect waves-light me-1"><i class="fa fa-print"></i></a>
                                                        <a wire:click="closeSuratPeminjaman" class="btn btn-danger" data-bs-dismiss="modal">Tutup</a>
                                                    {{-- </div> --}}
                                                </div>
                                            </div>
                                        </div>
                                    </div> <!-- end row -->
                                </div>
                            </div>
                        </div> <!-- end col -->
                    </div> <!-- end row -->
                </div>
            </div>
        </div>
    </div>
    
    {{-- view --}}
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4>Peminjaman List</h4>
                @if (Auth::user()->role == 'admin')
                <div class="d-flex align-items-center">
                    <div class="me-2">
                        <input type="date" class="form-control" wire:model="tanggalAwal" />
                    </div>
                    <div class="me-2">
                        <input type="date" class="form-control" wire:model="tanggalAkhir" />
                    </div>
                    <h4 wire:click="exportBarangKeluar" class="btn btn-success m-0">Export Excel</h4>
                </div>
                @endif
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
                        <th>Barang</th>
                        <th style="width:140px">Jumlah</th>
                        {{-- @if (Auth::user()->role == 'admin') --}}
                        <th style="width:250px" class="text-center">Aksi</th>
                        {{-- @endif --}}
                    </tr>
                    </thead>
                    <tbody>
                        @foreach($barangKeluars as $barangKeluar)
                            @if($barangKeluar->detailBarangKeluar->isEmpty())
                                <tr class="text-center" style="vertical-align: middle;">
                                    <td>PMJ-{{ $barangKeluar->id }}</td>
                                    @if (Auth::user()->role == 'admin')
                                    <td>{{ ucwords($barangKeluar->user->nama) }}</td>
                                    @endif
                                    <td>{{ \Carbon\Carbon::parse($barangKeluar->tanggal)->format('d/m/Y') }}</td>
                                    <td colspan="4">Tidak ada detail</td>
                                    <td class="text-center">
                                        <a onclick="confirmDelete('{{ $barangKeluar->id }}')" class="btn btn-danger btn-sm">Batalkan</a>
                                    </td>
                                </tr>
                            @else
                                @foreach($barangKeluar->detailBarangKeluar as $index => $detail)
                                    <tr @if($index == 0) class="parent-row" style="vertical-align: middle;" @endif data-id="{{ $barangKeluar->id }}">
                                        @if($index == 0)
                                            <td rowspan="{{ $barangKeluar->detailBarangKeluar->count() }}" class="text-center">PMJ-{{ $barangKeluar->id }}
                                            </td>
                                            @if (Auth::user()->role == 'admin')
                                            <td rowspan="{{ $barangKeluar->detailBarangKeluar->count() }}" class="text-center">{{ ucwords($barangKeluar->user->nama) }}
                                            </td>
                                            @endif
                                            <td rowspan="{{ $barangKeluar->detailBarangKeluar->count() }}" class="text-center">
                                                {{ \Carbon\Carbon::parse($barangKeluar->tanggal)->format('d/m/Y') }}
                                            </td>
                                        @endif
                                        <td class="text-center">{{ $detail->barang->nama }}</td>
                                        <td class="text-center">{{ $detail->jumlah }} {{ $detail->barang->satuan }}</td>
                                        @if($index == 0)
                                        <td rowspan="{{ $barangKeluar->detailBarangKeluar->count() }}" class="text-center">
                                            <a wire:click="openModalSuratPeminjaman('{{ $barangKeluar->id }}')" class="btn btn-warning btn-sm me-1">
                                                Surat Peminjaman
                                            </a>
                                            @if (Auth::user()->role == 'admin')
                                            <a onclick="confirmDelete('{{ $barangKeluar->id }}')" class="btn btn-danger btn-sm">Batalkan
                                            </a>
                                            @endif
                                        </td>
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
            Livewire.on('showModalSuratPeminjaman', () => {
            var modal = new bootstrap.Modal(document.getElementById('modalSuratPeminjaman'));
            modal.show();
            });

            Livewire.on('closeModalSuratPeminjaman', () => {
                var modal = bootstrap.Modal.getInstance(document.getElementById('modalSuratPeminjaman'));
                if (modal) {
                    modal.hide();
                }
            });
        });
        
        function confirmDelete(idBarangKeluar) {
            Swal.fire({
                title: "Anda yakin?",
                text: "Anda yakin ingin membatalkan peminjaman?",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#007bff",
                cancelButtonColor: "#dc3545",
                confirmButtonText: "Ya, batalkan!"
            }).then((result) => {
                if (result.isConfirmed) {
                    Livewire.emit('deleteBarangKeluar', idBarangKeluar);
                    Livewire.on('deleteBarangKeluarSuccess', (message) => {
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