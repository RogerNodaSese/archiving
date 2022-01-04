@extends('layout.dashboard')

@push('styles')
    @livewireStyles
@endpush


@section('header')
    <h2 class="display-5 col-md-9 col-lg-9">List of Programs</h2>
@endsection

@section('contents')
      @livewire('program-search')
@endsection

@push('scripts')
    @livewireScripts
@endpush