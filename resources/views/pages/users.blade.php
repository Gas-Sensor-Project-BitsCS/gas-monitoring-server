@extends('layouts.app')
@section('content')
    <div class="p-5">

        {{-- Header --}}
        <div class="page-header flex flex-row justify-between  mb-2">

            <div>
                <h1 class=" text-2xl font-semibold">
                    Users
                </h1>
                <p>Manage system users and access</p>
            </div>
            <div>
                {{-- Add User component --}}
                <livewire:add-user />
            </div>
        </div>


        {{-- Users table --}}
        <livewire:users-table/>


        

    </div>
@endsection

@push('scripts')
    {{-- <script>
        lucide.createIcons();
    </script> --}}
@endpush