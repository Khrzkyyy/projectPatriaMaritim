<div>
    <form wire:submit.prevent="createBarangMasuk" data-parsley-validate>
        @csrf
        <div class="row">
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="id_barang_keluar" class="form-label">No. Peminjaman</label>
                    <select id="id_barang_keluar" class="form-select @error('id_barang_keluar') is-invalid @enderror" wire:model="id_barang_keluar" required @if($isReadonly) disabled  @endif>
                        <option selected disabled value="">Pilih Barang Keluar</option>
                        @foreach ($barangKeluars as $barangKeluar)
                            <option value="{{ $barangKeluar->id}}">PMJ-{{ $barangKeluar->id }}</option>
                        @endforeach
                    </select>
                    @error('id_barang_keluar')
                        <div class="invalid-feedback">Kolom kosong!</div>
                    @enderror
                </div>
            </div>
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="tanggal" class="form-label">Tanggal</label>
                    <input type="date" class="form-control @error('tanggal') is-invalid @enderror" wire:model="tanggal" required @if($isReadonly) readonly @endif>
                    @error('tanggal')
                        <div class="invalid-feedback">Kolom kosong!</div>
                    @enderror
                </div>
            </div>
        </div>
        @if ($showButtonFormCreateBarangMasuk)
            <div class="text-end">
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
        @endif
    </form>

    <script>
        document.addEventListener('livewire:load', function () {
            Livewire.on('saveBarangMasukSuccess', (message) => {
                Swal.fire({
                    title: "Berhasil!",
                    text: message,
                    icon: "success",
                    showConfirmButton: false,
                    timer: 3000,
                });
            });
            
            Livewire.on('saveBarangMasukFailed', (message) => {
                Swal.fire({
                    title: "Gagal!",
                    text: message,
                    icon: "error",
                    showConfirmButton: false,
                    timer: 3000,
                });
            });
            
            Livewire.on('saveBarangMasukError', (message) => {
                Swal.fire({
                    title: "Gagal!",
                    text: message,
                    icon: "error",
                    showConfirmButton: false,
                    timer: 3000,
                });
            });
        });
    </script>
</div>