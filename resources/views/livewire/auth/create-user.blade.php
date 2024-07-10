<div>
    <form wire:submit.prevent="createUser" data-parsley-validate>
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
                    <label for="role" class="form-label">Role</label>
                    <select class="form-select @error('role') is-invalid @enderror" wire:model="role" required @if($isReadonly) disabled  @endif>
                        <option selected disabled value="">Pilih Role</option>
                        <option value="admin">Admin</option>
                        <option value="user">User</option>
                    </select>
                    @error('role')
                        <div class="invalid-feedback">Role harus di pilih</div>
                    @enderror
                </div>
            </div>
            <div class="col-md-4">
                <div class="mb-3">
                    <label for="no_telp" class="form-label">No. Telpon</label>
                    <input type="number" class="form-control @error('no_telp') is-invalid @enderror" wire:model="no_telp" required>
                    @error('no_telp')
                        <div class="invalid-feedback">No. Telpon harus di isi</div>
                    @enderror
                </div>
            </div>
            <div class="col-md-4">
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control @error('password') is-invalid @enderror" wire:model="password" required>
                    @error('password')
                        <div class="invalid-feedback">Password minimal 8 karakter</div>
                    @enderror
                </div>
            </div>
            <div class="col-md-4">
                <div class="mb-3">
                    <label for="password_confirmation" class="form-label">Konfirmasi Password</label>
                    <input type="password" class="form-control @error('password_confirmation') is-invalid @enderror" wire:model="password_confirmation" required>
                    @error('password_confirmation')
                        <div class="invalid-feedback">Password tidak sama</div>
                    @enderror
                </div>
            </div>
        </div>
        <div class="text-end">
            <button type="submit" class="btn btn-primary">Simpan</button>
        </div>
    </form>

    <script>
        document.addEventListener('livewire:load', function () {
            Livewire.on('closeModal', () => {
                let modalElement = document.getElementById('modalCreateUser');
                let modal = bootstrap.Modal.getInstance(modalElement);
                if (modal) {
                    modal.hide();
                }
            });

            Livewire.on('existingUserFailed', (message) => {
                Swal.fire({
                    title: "Gagal!",
                    text: message,
                    icon: "info",
                    showConfirmButton: false,
                    timer: 800,
                });
            });
            
            Livewire.on('saveUserSuccess', (message) => {
                Swal.fire({
                    title: "Berhasil!",
                    text: message,
                    icon: "success",
                    showConfirmButton: false,
                    timer: 800,
                });
            });
            
            Livewire.on('saveUserFailed', (message) => {
                Swal.fire({
                    title: "Gagal!",
                    text: message,
                    icon: "error",
                    showConfirmButton: false,
                    timer: 800,
                });
            });
            
            Livewire.on('saveUserError', (message) => {
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