@extends('layout.dashboard')

@push('styles')
    @livewireStyles
@endpush


@section('header')
    <h2 class="display-5 col-md-9 col-lg-9">Create Archives</h2>
    <a href="{{route('archives.export')}}" class="btn btn-success">Download template</a>
@endsection

@section('contents')
    <livewire:import />
@endsection

@push('scripts')
    @livewireScripts
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@endpush