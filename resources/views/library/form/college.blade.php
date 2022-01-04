@extends('layout.dashboard')

@push('styles')
    @livewireStyles
@endpush

@section('header')
    <h2 class="display-5 col-md-9 col-lg-9">College Form</h2>
@endsection

@section('breadcrumbs')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="{{route('student.colleges')}}">Colleges</a></li>
      <li class="breadcrumb-item active" aria-current="page">Create</li>
    </ol>
</nav>
@endsection

@section('contents')
<div class="container">
    <livewire:college-form/>
</div>
@endsection

@push('scripts')
    @livewireScripts
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@endpush

{{-- @if (session('message')) --}}
    @push('scripts')
    <script>
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 4000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
        })
        
           window.addEventListener('toastr:created', event => {
                Toast.fire({
                    icon: event.detail.icon,
                    title: event.detail.title,
                })
           })
</script> 
    @endpush
{{-- @endif --}}


