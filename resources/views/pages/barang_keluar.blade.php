@extends('layouts.main')

@section ('title', 'Peminjaman Barang')

@section('content')
    {{-- create --}}
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                @livewire('barang-keluar.create-barang-keluar')
                @livewire('detail-barang-keluar.create-detail-barang-keluar')
            </div>
        </div>
    </div>

    {{-- view --}}
    @livewire('barang-keluar.view-barang-keluar')
    
@endsection