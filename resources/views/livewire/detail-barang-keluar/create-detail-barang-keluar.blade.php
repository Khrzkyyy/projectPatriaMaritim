<div>
    @if ($showFormCreateDetailBarangKeluar)
        <form wire:submit.prevent="createDetailBarangKeluar" data-parsley-validate>
            @csrf
            {{-- <div class="row">
                <div class="col-md-12">
                    <div class="mb-3">
                        <label for="id_barang_keluar" class="form-label">No. Peminjaman</label>
                        <input type="number" class="form-control @error('id_barang_keluar') is-invalid @enderror" wire:model="id_barang_keluar" required readonly>
                    </div>
                </div>
            </div> --}}
            @foreach ($rows as $index => $row)
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-4">
                        <label for="id_barang_{{ $index }}" class="form-label">Barang</label>
                        <select id="id_barang_{{ $index }}" class="form-select" wire:model="rows.{{ $index }}.id_barang" required>
                            <option selected disabled value="">Pilih Barang</option>
                            @foreach ($barangs as $barang)
                                <option value="{{ $barang->id }}">{{ $barang->nama }}</option>
                            @endforeach
                        </select>
                        @error('rows.{{ $index }}.id_barang')
                            <div class="invalid-feedback">Kolom kosong!</div>
                        @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="jumlah_{{ $index }}" class="form-label">Jumlah</label>
                        <input id="jumlah_{{ $index }}" type="number" class="form-control" wire:model="rows.{{ $index }}.jumlah" required>
                        @error('rows.{{ $index }}.jumlah')
                            <div class="invalid-feedback">Kolom kosong!</div>
                        @enderror
                    </div>
                </div>
            </div>
            @endforeach
            <div class="text-end">
                @if (count($rows) > 1)
                <button type="button" class="btn btn-danger" wire:click="removeRow({{ $index }})">Hapus</button>
                @endif
                <button type="button" class="btn btn-success" wire:click="addNewRow">Tambah</button>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
        </form>
    @endif

    <script>
        document.addEventListener('livewire:load', function () {
            Livewire.on('saveDetailBarangKeluarSuccess', (message) => {
                Swal.fire({
                    title: "Berhasil!",
                    text: message,
                    icon: "success",
                    showConfirmButton: false,
                    timer: 1000,
                });
            });
            
            Livewire.on('saveDetailBarangKeluarError', (message) => {
                Swal.fire({
                    title: "Gagal!",
                    text: message,
                    icon: "error",
                    showConfirmButton: false,
                    timer: 1000,
                });
            });
        });
    </script>
</div>