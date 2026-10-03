@extends('layouts.app')
@section('content')
<livewire:users />
@endsection

@push('scripts')
    <script>
        lucide.createIcons();
    </script>
@endpush
