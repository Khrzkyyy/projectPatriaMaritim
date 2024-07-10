<div>
    <form wire:submit.prevent="createBarangKeluar" data-parsley-validate>
        @csrf
        <div class="row">
            <div class="col-md-12">
                <div class="mb-3">
                    <label for="tanggal" class="form-label">Tanggal</label>
                    <input type="date" class="form-control @error('tanggal') is-invalid @enderror" wire:model="tanggal" required @if($isReadonly) readonly @endif>
                    @error('tanggal')
                        <div class="invalid-feedback">Kolom kosong!</div>
                    @enderror
                </div>
            </div>
        </div>
        @if ($showButtonFormCreateBarangKeluar)
        <div class="text-end">
            <button type="submit" class="btn btn-primary">Simpan</button>
        </div>
        @endif
    </form>

    <script>document.addEventListener('livewire:load', function () {
        Livewire.on('saveBarangKeluarFailed', (message) => {
            Swal.fire({
                title: "Gagal!",
                text: message,
                icon: "error",
                showConfirmButton: false,
                timer: 800,
            });
        });
        
        Livewire.on('saveBarangKeluarError', (message) => {
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