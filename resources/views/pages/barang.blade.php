@extends('layouts.main')

@section ('title', 'Barang')

@section('content')
    {{-- create --}}
    <div class="col-12">
        <div class="card">
            <div class="card-body">
            @livewire('barang.create-barang')
        </div>
    </div>

    {{-- view --}}
    @livewire('barang.view-barang')

    {{-- edit --}}
    <div wire:ignore.self class="modal fade" id="modalEditBarang" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="modalEditBarangLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalEditBarangLabel">Update Data</h5>
                    <button type="button" class="btn-close waves-effect" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div>
                    @livewire('barang.update-barang')
                </div>
            </div>
        </div>
    </div>
@endsection