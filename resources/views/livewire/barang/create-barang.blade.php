<div>
    <form wire:submit.prevent="createBarang" data-parsley-validate>
        @csrf
        <div class="row">
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="id_kategori" class="form-label">Kategori</label>
                    <select id="id_kategori" class="form-select @error('id_kategori') is-invalid @enderror" wire:model="id_kategori" required>
                        <option selected disabled value="">Pilih Kategori</option>
                        @foreach ($kategoris as $kategori)
                            <option value="{{ $kategori->id}}">{{ $kategori->nama }}</option>
                        @endforeach
                    </select>
                    @error('id_kategori')
                        <div class="invalid-feedback">Kolom kosong!</div>
                    @enderror
                </div>
            </div>
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="nama" class="form-label">Barang</label>
                    <input type="text" class="form-control @error('nama') is-invalid @enderror" wire:model="nama" required>
                    @error('nama')
                        <div class="invalid-feedback">Kolom kosong!</div>
                    @enderror
                </div>
            </div>
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="jumlah" class="form-label">Jumlah</label>
                    <input type="number" class="form-control @error('jumlah') is-invalid @enderror" wire:model="jumlah" required>
                    @error('jumlah')
                        <div class="invalid-feedback">Kolom kosong!</div>
                    @enderror
                </div>
            </div>
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="satuan" class="form-label">Satuan</label>
                    <input type="text" class="form-control @error('satuan') is-invalid @enderror" wire:model="satuan" required>
                    @error('satuan')
                        <div class="invalid-feedback">Kolom kosong!</div>
                    @enderror
                </div>
            </div>
        </div>
        <div class="d-flex justify-content-end">
            <button type="submit" class="btn btn-primary">Simpan</button>
        </div>
    </form>

    <script>
        document.addEventListener('livewire:load', function () {
            Livewire.on('existingBarangFailed', (message) => {
                Swal.fire({
                    title: "Gagal!",
                    text: message,
                    icon: "info",
                    showConfirmButton: false,
                    timer: 800,
                });
            });
            
            Livewire.on('saveBarangSuccess', (message) => {
                Swal.fire({
                    title: "Berhasil!",
                    text: message,
                    icon: "success",
                    showConfirmButton: false,
                    timer: 800,
                });
            });
            
            Livewire.on('saveBarangFailed', (message) => {
                Swal.fire({
                    title: "Gagal!",
                    text: message,
                    icon: "error",
                    showConfirmButton: false,
                    timer: 800,
                });
            });
            
            Livewire.on('saveBarangError', (message) => {
                Swal.fire({
                    title: "Gagal!",
                    text: message,
                    icon: "error",
                    showConfirmButton: false,
                    timer: 800,
                });
            });
        });
    </script>
</div>