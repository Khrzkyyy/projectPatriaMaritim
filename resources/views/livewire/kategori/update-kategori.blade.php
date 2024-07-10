<div>
    <form wire:submit.prevent="updateKategori">
        <div class="modal-body">
            @csrf
            <div class="row">
                <div class="col-md-12">
                    <div class="mb-3">
                        <label for="nama" class="form-label">Nama Kategori</label>
                        <input type="text" class="form-control @error('nama') is-invalid @enderror" wire:model="nama" required>
                        @error('nama')
                            <div class="invalid-feedback">Kolom harus di isi</div>
                        @enderror
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Tutup</button>
            <button type="submit" class="btn btn-primary">Simpan</button>
        </div>
    </form>
    
    <script>
        document.addEventListener('livewire:load', function () {
            Livewire.on('closeModal', () => {
                let modalElement = document.getElementById('modalEditKategori');
                let modal = bootstrap.Modal.getInstance(modalElement);
                if (modal) {
                    modal.hide();
                }
            });
    
            Livewire.on('updateKategoriSuccess', (message) => {
                Swal.fire({
                    title: "Berhasil!",
                    text: message,
                    icon: "success",
                    showConfirmButton: false,
                    timer: 800,
                });
            });

            Livewire.on('updateKategoriFailed', (message) => {
                Swal.fire({
                    title: "Gagal!",
                    text: message,
                    icon: "error",
                    showConfirmButton: false,
                    timer: 800,
                });
            });
            
            Livewire.on('updateKategoriError', (message) => {
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