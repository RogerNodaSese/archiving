@extends('layout.dashboard')

@push('styles')
    @livewireStyles
@endpush

@section('header')
    <h2 class="display-5 col-md-9 col-lg-9">Create archive</h2>
@endsection

@section('breadcrumbs')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="/archives">Archives</a></li>
      <li class="breadcrumb-item active" aria-current="page">Create</li>
    </ol>
</nav>
@endsection

@section('contents')
    <livewire:thesis-form/>
@endsection

@push('scripts')
    @livewireScripts
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@endpush

{{-- @if (session('message')) --}}
    @push('scripts')
    <script>  
           window.addEventListener('toastr:created', event => {
                Swal.fire({
                    icon: 'success',
                    title: 'Thesis saved successfully!',
                    showConfirmButton: true,
                    timer: 10000
                })
           })
</script> 
    @endpush
{{-- @endif --}}


