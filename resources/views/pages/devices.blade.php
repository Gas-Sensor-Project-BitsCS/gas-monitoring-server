@extends('layouts.app')
@section('content')
    <div class="p-5">

        {{-- Header --}}
        <div class="page-header flex flex-row justify-between  mb-2">

            <div>
                <h1 class=" text-2xl font-semibold">
                    Devices
                </h1>
                <p>Manage system Devices and access</p>
            </div>
            <div>
                {{-- Add User component --}}
                {{-- <livewire:add-device /> --}}
            </div>
        </div>


        {{-- Users table --}}
        <livewire:devices-table/>


        

    </div>
@endsection

@push('scripts')
    {{-- <script>
        lucide.createIcons();
    </script> --}}
@endpush