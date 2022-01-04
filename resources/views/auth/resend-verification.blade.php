@extends('layout.app')

@push('styles')
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link href="{{ asset('css/login.css') }}" rel="stylesheet">
@endpush

@section('content')
@foreach ($errors->all() as $error)
    <li>
        {{$error}}
    </li>
@endforeach
<section class="my-4 mx-5">
    <div class="status">
        @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <div class="text-sm text-success">
                <h4><b>{{ session('success') }}</b></h4>
            </div>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        @endif
        @if (session('fail'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <div class="text-sm text-danger">
                <h4><b>{{ session('fail') }}</b></h4>
            </div>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        @endif
    </div>
    <div class="container my-5">
        <div class="row no-gutters">
            <div class="image col-lg-6 d-flex justify-content-center py-5">
                <img src="{{ asset('/storage//logo.png') }}" alt="" class="img-fluid my-5 ">
            </div>
            <div class="welcome col-lg-6 px-5 pt-5 mt-2">
                <div class="d-flex flex-column">
                    <h2 class="header pb-3 d-flex align-self-center">Re-send Email Verification</h2>
                </div>
                <form action="{{ route('verification.resend') }}" method="POST" class="mt-2">
                    @csrf
                  
                    <div class="form-row d-flex flex-column mb-3">
                        <div class="col-lg-10 d-flex align-self-center">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">
                                        <span class="material-icons">email</span>
                                    </div>
                                </div>
                                <input type="email" name="email" class="form-control" placeholder="ex. juan.delacruz@neu.edu.ph">
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-lg-8 d-flex flex-column">
                        <a href="{{ route('login') }}" class="d-flex align-self-center">Already have an account? Click here to Login</a>
                    </div>
                    <div class="form-row">
                        <div class="col-lg-11">
                            <button type="submit" class="btn btn-primary float-right mt-2 mb-4">Send</button>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>
</section>

@push('scripts')
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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
    </script>
@endpush

@if (session('error'))
    @push('scripts')
    <script>
               Toast.fire({
                   icon: 'error',
                   title: '{{session("error")}}',
               })
    </script>
    @endpush
    @elseif(session('success'))
    <script>
               Toast.fire({
                   icon: 'success',
                   title: '{{session("success")}}',
               })
    </script>
@endif
@endsection