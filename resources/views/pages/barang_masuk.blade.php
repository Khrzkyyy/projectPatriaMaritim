@extends('layouts.main')

@section ('title', 'Pengembalian Barang')

@section('content')
    {{-- create --}}
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                @livewire('barang-masuk.create-barang-masuk')
                @livewire('detail-barang-masuk.create-detail-barang-masuk')
            </div>
        </div>
    </div>

    {{-- view --}}
    @livewire('barang-masuk.view-barang-masuk')

@endsection