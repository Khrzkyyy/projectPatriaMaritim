@extends('layouts.main')

@section ('title', 'Kategori')

@section('content')
    {{-- create --}}
    <div class="col-12">
        <div class="card">
            <div class="card-body">
            @livewire('kategori.create-kategori')
        </div>
    </div>

    {{-- view --}}
    @livewire('kategori.view-kategori')

    {{-- edit --}}
    <div wire:ignore.self class="modal fade" id="modalEditKategori" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="modalEditKategoriLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalEditKategoriLabel">Update Data</h5>
                    <button type="button" class="btn-close waves-effect" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div>
                    @livewire('kategori.update-kategori')
                </div>
            </div>
        </div>
    </div>
@endsection