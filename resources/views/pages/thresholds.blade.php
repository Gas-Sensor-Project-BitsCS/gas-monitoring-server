@extends('layouts.app')
@section('content')
<livewire:device-threshold />
@endsection

@push('scripts')
    <script>
        lucide.createIcons();
    </script>
@endpush