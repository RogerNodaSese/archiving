<div class="img-container py-4 px-3 mb-5 d-flex justify-content-center">
    <div class="media">
        <img src="https://neu.edu.ph/main/assets/images/NEU_LOGO.png" alt="" width="80" height="80" class="logo rounded-circle img-thumbnail shadow-sm">
    </div>
</div>


@if (auth()->user()->role_id != \App\Models\Role::STUDENT)   
<p class="font-weight-bold text-uppercase px-3 small pb-4 mb-0 section">Dashboard</p> 
<ul class="nav flex-column bg-white mb-0">
    <li class="nav-item">

        @if(auth()->user()->role_id == \App\Models\Role::ADMIN)
            <a href="/college" class="nav-link @if(\Request::routeIs('college.index'))bg-info text-white @else text-dark bg-light @endif">   
        @else
            <a href="/library" class="nav-link @if(\Request::routeIs('library.index'))bg-info text-white @else text-dark bg-light @endif">    
        @endif
            <span class="material-icons">
                grid_view
            </span>
                <small>Home</small>
        </a>
    </li>
</ul>
@endif

    <p class="font-weight-bold text-uppercase px-3 small pb-4 mb-0 mt-3 section">Contents</p>
    <ul class="nav flex-column bg-white mb-0">
        <li class="nav-item">
            <a href="/archives" class="nav-link @if(\Request::routeIs('student.index'))bg-info text-white @else text-dark bg-light @endif">
                <span class="material-icons">
                    archive
                </span>
                <small>Archives</small>
            </a>
        </li>
@if (auth()->user()->role_id == \App\Models\Role::SUPER_ADMIN)

    <li class="nav-item">
            <a href="{{route('library.users')}}" class="nav-link @if(\Request::routeIs('library.users'))bg-info text-white @else text-dark bg-light @endif">
                <span class="material-icons">
                    group
                </span>
                <small>Users</small>
            </a>
        </li>
            <li class="nav-item">
                <a href="{{route('library.requests')}}" class="nav-link @if(\Request::routeIs('library.requests'))bg-info text-white @else text-dark bg-light @endif">
                    <span class="material-icons">
                        move_to_inbox
                    </span>
                    <small>Archive Requests</small>
                    {{-- only thesis to query --}}
                    @php
                        $requestCount = \App\Models\Thesis::where('verified', false)->count();
                    @endphp
                    @if($requestCount > 0)
                    <span class="badge badge-dark"> {{$requestCount}} </span>  
                    @endif
                </a>
            </li>
@endif
</ul>

{{-- 
@if (auth()->user()->role_id == \App\Models\Role::STUDENT) --}}
<p class="font-weight-bold text-uppercase px-3 small pb-4 mb-0 mt-3 section">Filter</p>

<ul class="nav flex-column bg-white mb-0">
    <li class="nav-item">
        <a href="{{route('student.colleges')}}" class="nav-link  @if(\Request::routeIs('student.colleges'))bg-info text-white @else text-dark bg-light @endif">
            <span class="material-icons">
                foundation
            </span>
            <small>Colleges</small>
        </a>
    </li>
    <li class="nav-item">
        <a href="{{route('student.programs')}}" class="nav-link  @if(\Request::routeIs('student.programs'))bg-info text-white @else text-dark bg-light @endif">
            <span class="material-icons">
                group
            </span>
            <small>Programs</small>
        </a>
    </li>
    <li class="nav-item">
        <a href="" class="nav-link text-dark bg-light">
            <span class="material-icons">
                people
            </span>
                <small>Author</small>
        </a>
    </li>

    <li class="nav-item">
        <a href="{{route('student.title')}}" class="nav-link @if(\Request::routeIs('student.title'))bg-info text-white @else text-dark bg-light @endif">
            <span class="material-icons">
                title
            </span>
                <small>Title</small>
        </a>
    </li>

    <li class="nav-item">
        <a href="{{route('student.keywords')}}" class="nav-link @if(\Request::routeIs('student.keywords'))bg-info text-white @else text-dark bg-light @endif">
            <span class="material-icons">
                feed
            </span>
                <small>Keywords</small>
        </a>
    </li>

    <li class="nav-item">
        <a href="{{route('student.subjects')}}" class="nav-link @if(\Request::routeIs('student.subjects'))bg-info text-white @else text-dark bg-light @endif">
            <span class="material-icons">
                subject
            </span>
                <small>Subjects</small>
        </a>
    </li>
</ul>
{{-- @endif --}}

<p class="font-weight-bold text-uppercase px-3 small pb-4 mb-0 mt-3 section">Action</p>

<form action="{{ route('logout') }}" method="POST">
    @csrf
<ul class="nav flex-column bg-white mb-0">
    <li class="nav-item">
        <button class="nav-link text-dark bg-light btn btn-link">
            <span class="material-icons">
                logout
            </span>
                <small>Logout</small>
        </button>
        
    </li>
</ul>
</form>
</div>
