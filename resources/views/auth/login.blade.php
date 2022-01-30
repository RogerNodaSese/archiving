@extends('layout.app')

@push('styles')
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link href="{{ asset('css/login.css') }}" rel="stylesheet">
@endpush

@section('content')

<section class="my-4 mx-5">
    <div class="status">
        @if (session('status'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <div class="text-sm text-danger">
                <h4><b>{{ session('status') }}</b></h4>
            </div>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        @endif
    </div>
    <div class="container my-5">
        <div class="row no-gutters ">
            <div class="image col-lg-6 d-flex justify-content-center py-5">
                <img src="https://neu.edu.ph/main/assets/images/NEU_LOGO.png" alt="" class="img-fluid my-5 ">
            </div>
            <div class="welcome col-lg-6 px-5 pt-5 mt-5">
                <div class="d-flex flex-column">
                    <small class="header d-flex align-self-center">WELCOME TO NEW ERA UNIVERSITY</small>
                    <h2 class="header pb-3 d-flex align-self-center">THESIS ARCHIVES</h2>
                </div>
                <form action="{{ route('login') }}" method="POST" class="mt-1">
                    @csrf
                    <div class="form-row d-flex flex-column mb-3">
                        
                        <div class="col-lg-10 d-flex align-self-center">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">
                                        <span class="material-icons">person</span>
                                    </div>
                                </div>
                                <input type="email" name="email" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="form-row d-flex flex-column">
                        <div class="col-lg-10 d-flex align-self-center">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">
                                        <span class="material-icons">lock</span>
                                    </div>
                                </div>
                                <input type="password" name="password" class="form-control ">
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-5 d-flex flex-column">
                        <a href="{{ route('register') }}" class="d-flex align-self-center">Click here to sign up</a>
                        <a href="{{ route('resend') }}" class="d-flex align-self-center">Re-send verification.</a>
                    </div>
                    <div class="form-row">
                        <div class="col-lg-11">
                            <button type="submit" class="btn btn-primary float-right mt-2 mb-4">Login</button>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>
</section>


@endsection

