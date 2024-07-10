<div>
    <form wire:submit.prevent="updateUser">
        <div class="modal-body">
            @csrf
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="nama" class="form-label">Nama</label>
                        <input type="text" class="form-control @error('nama') is-invalid @enderror" wire:model="nama" required>
                        @error('nama')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="no_telp" class="form-label">No. Telpon</label>
                        <input type="number" class="form-control @error('no_telp') is-invalid @enderror" wire:model="no_telp" required>
                        @error('no_telp')
                            <div class="invalid-feedback">No. Telpon harus di isi</div>
                        @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control @error('password') is-invalid @enderror" wire:model="password" required>
                        @error('password')
                            <div class="invalid-feedback">Password minimal 8 karakter</div>
                        @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="password_confirmation" class="form-label">Konfirmasi Password</label>
                        <input type="password" class="form-control @error('password_confirmation') is-invalid @enderror" wire:model="password_confirmation" required>
                        @error('password_confirmation')
                            <div class="invalid-feedback">Password tidak sama</div>
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
            Livewire.on('updateUserSuccess', (message) => {
                Swal.fire({
                    title: "Berhasil!",
                    text: message,
                    icon: "success",
                    showConfirmButton: false,
                    timer: 800,
                });
            });

            Livewire.on('updateUserFailed', (message) => {
                Swal.fire({
                    title: "Gagal!",
                    text: message,
                    icon: "error",
                    showConfirmButton: false,
                    timer: 800,
                });
            });

            Livewire.on('updateUserError', (message) => {
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