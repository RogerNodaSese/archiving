@extends('layout.dashboard')


@push('styles')
    @livewireStyles
@endpush

@section('header')
    <h2 class="display-5 col-md-9 col-lg-9">Change Password</h2>
@endsection
@section('contents')
    <livewire:change-password/>
@endsection

@push('scripts')
    @livewireScripts
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@endpush

@push('scripts')
    <script>  
           window.addEventListener('toastr:changed', event => {
            console.log(event)
                Swal.fire({
                    icon: event.detail.icon,
                    title: event.detail.title,
                    showConfirmButton: true,
                    timer: 10000
                })
           })
</script> 
    @endpush

