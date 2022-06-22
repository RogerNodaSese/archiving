@extends('layout.app')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
@endpush

@section('content')
<div class="vertical-nav bg-light" id="sidebar">
    @include('layout.sidebar')
    
    <div class="page-content p-5" id="content">
        <button id="sidebarCollapse" type="button" class="btn ">
            <span class="material-icons">
                menu
            </span>
        </button>
        <div class="content card p-5 my-1" style="border-radius: 20px;box-shadow:3px 4px #808080;background:#FFF5EE">
            <div class="row">
            @yield('header') 
            <div class="col-md-4 col-lg-4 ml-auto" style="">
                @if (auth()->user()->role_id == \App\Models\Role::ADMIN || auth()->user()->role_id == \App\Models\Role::STAFF)
                    @if(\Request::routeIs('student.*') && !(\Request::routeIs('student.colleges') || \Request::routeIs('student.programs')))
                        <a href="{{route('library.thesis.create')}}" class="btn btn-success float-right" id="inputPassword">Create Archive</a>
                    @elseif(\Request::routeIs('student.colleges'))
                        <a href="{{route('library.college.create')}}" class="btn btn-success float-right" id="inputPassword">+ Add College</a>
                    @elseif(\Request::routeIs('student.programs'))
                        <a href="{{route('program.create')}}" class="btn btn-success float-right" id="inputPassword">+ Add Programs</a>
                    @elseif(\Request::routeIs('library.staff-activity'))
                        <a href="{{route('library.staff.create')}}" class="btn btn-success float-right" id="inputPassword">+ Add Staff</a>
                    @endif
                    @if(\Request::routeIs('student.archive'))
                        @yield('edit')
                    @endif
                @endif
                @if (auth()->user()->role_id == \App\Models\Role::ADMIN)
                    @if(\Request::routeIs('library.users'))
                <a href="{{route('library.users.create')}}" class="btn btn-success" id="inputPassword">+ Add admin</a>
                    @endif
                @endif
            </div>
            </div>
            @yield('breadcrumbs')
            <div class="separator"></div>
            @yield('title')
            <div class="row text-dark justify-content-center">

                @yield('contents')

            </div>
            @yield('recent')
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
    <script src="{{ asset('js/sidebar.js') }}"></script>
@endpush