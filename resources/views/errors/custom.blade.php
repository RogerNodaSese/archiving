@extends('layout.app')

@push('styles')
    <style>
        body{
            background-image: url(https://media-exp1.licdn.com/dms/image/C561BAQGUxB_pssZkJA/company-background_10000/0/1591598520082?e=2159024400&v=beta&t=ZBbCTQxKfeKlkXkME-zXjM_UuW7V9WhAfAh6WOSfWWQ);
            background-repeat: no-repeat;
            background-size: cover;
            background-position-x: 100%;
            background-position-y: 95%;
            overflow: hidden;
        }
        @media only screen and (max-width: 600px) {
            body{
                background-position: 55%;
            }
        }
    </style>
@endpush

@section('content')
        <div class="row">
            <div class="col-6 bg-white d-flex justify-content-center" style="height: 100vh; opacity:80%">
                <div class="d-flex flex-column mt-5">
                    <h1 class="display-1 font-weight-bold mt-5">
                        @yield('code')
                    </h1>
                    <p class="lead text-center font-weight-bold">
                        @yield('message')
                    </p>
                    <a href="{{route('login')}}" class="btn btn-dark text-light font-weight-bold mt-5"><< Back</a>
                </div>
            </div>

            <div class="col-6">
            </div>
        </div>
@endsection