@extends('layouts.main')

@section ('title', 'Users')

@section('content')
    {{-- create-update user --}}
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                @livewire('auth.create-user')
            </div>
        </div>
    </div>

    {{-- view --}}
    @livewire('auth.view-user')

    {{-- update --}}
    <div wire:ignore.self class="modal fade" id="modalEditUser" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="modalEditUserLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalEditUserLabel">Update Data</h5>
                    <button type="button" class="btn-close waves-effect" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div>
                    @livewire('auth.update-user')
                </div>
            </div>
        </div>
    </div>
@endsection