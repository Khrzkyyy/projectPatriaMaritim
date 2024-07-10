<div>
    <form wire:submit.prevent="createKategori" data-parsley-validate>
        @csrf
        <div class="mb-3">
            <label for="nama" class="form-label">Kategori</label>
            <input type="text" class="form-control @error('nama') is-invalid @enderror" wire:model="nama" required>
            @error('nama')
                <div class="invalid-feedback">Kolom kosong!</div>
            @enderror
        </div>
        <div class="d-flex justify-content-end">
            <button type="submit" class="btn btn-primary">Simpan</button>
        </div>
    </form>

    <script>
        document.addEventListener('livewire:load', function () {
            Livewire.on('existingKategoriFailed', (message) => {
                Swal.fire({
                    title: "Gagal!",
                    text: message,
                    icon: "info",
                    showConfirmButton: false,
                    timer: 800,
                });
            });
            
            Livewire.on('saveKategoriSuccess', (message) => {
                Swal.fire({
                    title: "Berhasil!",
                    text: message,
                    icon: "success",
                    showConfirmButton: false,
                    timer: 800,
                });
            });
            
            Livewire.on('saveKategoriFailed', (message) => {
                Swal.fire({
                    title: "Gagal!",
                    text: message,
                    icon: "error",
                    showConfirmButton: false,
                    timer: 800,
                });
            });
            
            Livewire.on('saveKategoriError', (message) => {
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