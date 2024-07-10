<div>
    <form wire:submit.prevent="updateBarang">
        <div class="modal-body">
            @csrf
            <div class="row">
                <div class="col-md-4">
                    <div class="mb-3">
                        <label for="nama" class="form-label">Nama Barang</label>
                        <input type="text" class="form-control @error('nama') is-invalid @enderror" wire:model="nama" required>
                        @error('nama')
                            <div class="invalid-feedback">Kolom kosong</div>
                        @enderror
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="mb-3">
                        <label for="jumlah" class="form-label">Jumlah</label>
                        <input type="text" class="form-control @error('jumlah') is-invalid @enderror" wire:model="jumlah" required>
                        @error('jumlah')
                            <div class="invalid-feedback">Kolom kosong</div>
                        @enderror
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="mb-3">
                        <label for="satuan" class="form-label">Satuan</label>
                        <input type="text" class="form-control @error('satuan') is-invalid @enderror" wire:model="satuan" required>
                        @error('satuan')
                            <div class="invalid-feedback">Kolom kosong</div>
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
                let modalElement = document.getElementById('modalEditBarang');
                let modal = bootstrap.Modal.getInstance(modalElement);
                if (modal) {
                    modal.hide();
                }
            });
    
            Livewire.on('updateBarangSuccess', (message) => {
                Swal.fire({
                    title: "Berhasil!",
                    text: message,
                    icon: "success",
                    showConfirmButton: false,
                    timer: 800,
                });
            });

            Livewire.on('updateBarangFailed', (message) => {
                Swal.fire({
                    title: "Gagal!",
                    text: message,
                    icon: "error",
                    showConfirmButton: false,
                    timer: 800,
                });
            });
            
            Livewire.on('updateBarangError', (message) => {
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