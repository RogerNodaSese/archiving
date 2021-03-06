<div class="img-container py-4 px-3 mb-5 d-flex justify-content-center">
    <div class="media">
        <img src="https://neu.edu.ph/main/assets/images/NEU_LOGO.png" alt="" width="80" height="80" class="logo rounded-circle img-thumbnail shadow-sm">
    </div>
</div>


@if(auth()->user()->role_id == \App\Models\Role::ADMIN)
<p class="font-weight-bold text-uppercase px-3 small pb-4 mb-0 section">Dashboard</p> 
<ul class="nav flex-column bg-white mb-0">
    <li class="nav-item">
            <a href="/library" class="nav-link @if(\Request::routeIs('library.index'))bg-info text-white @else text-dark bg-light @endif">    
            <span class="material-icons">
                grid_view
            </span>
                <small>Home</small>
        </a>
    </li>
    {{-- @if(auth()->user()->role_id == \App\Models\Role::STUDENT)
        <li class="nav-item">
            <a href="/library" class="nav-link @if(\Request::routeIs('library.index'))bg-info text-white @else text-dark bg-light @endif">    
                <span class="material-icons">
                    grid_view
                </span>
                <small>Home</small>
            </a>
        </li>
        @endif --}}
    </ul>
    @endif

    @if(auth()->user()->role_id == \App\Models\Role::STAFF)
<p class="font-weight-bold text-uppercase px-3 small pb-4 mb-0 section">Dashboard</p> 
<ul class="nav flex-column bg-white mb-0">
    <li class="nav-item">
            <a href="/staff" class="nav-link @if(\Request::routeIs('staff.index'))bg-info text-white @else text-dark bg-light @endif">    
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
        {{-- @if(auth()->user()->role_id == \App\Models\Role::ADMIN)
        <li class="nav-item">
            <a href="{{route('archives.import')}}" class="nav-link @if(\Request::routeIs('archives.import'))bg-info text-white @else text-dark bg-light @endif">
                <span class="material-icons">
                    file_upload
                </span>
                <small>Import</small>
            </a>
        </li>
        @endif --}}
        @if(auth()->user()->role_id == \App\Models\Role::ADMIN)
        <li class="nav-item">
            <a href="/activity/staff" class="nav-link @if(\Request::routeIs('library.staff-activity'))bg-info text-white @else text-dark bg-light @endif">
                <span class="material-icons">
                    group
                </span>
                <small>Staffs</small>
            </a>
        </li>
        @endif
{{-- @if (auth()->user()->role_id == \App\Models\Role::SUPER_ADMIN)

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
                    <small>Archive Requests</small> --}}
                    {{-- only thesis to query --}}
                    {{-- @php
                        $requestCount = \App\Models\Thesis::where('verified', false)->count();
                    @endphp
                    @if($requestCount > 0)
                    <span class="badge badge-dark"> {{$requestCount}} </span>  
                    @endif
                </a>
            </li>
@endif --}}

{{-- @if(auth()->user()->role_id == \App\Models\Role::ADMIN)
<li class="nav-item">
    <a href="{{route('college.requests')}}" class="nav-link @if(\Request::routeIs('college.requests'))bg-info text-white @else text-dark bg-light @endif">
        <span class="material-icons">
            list_alt
        </span>
        <small>Request</small>
        @php
            $rejectedCount = \App\Models\Thesis::whereRelation('program', 'college_id', auth()->user()->college_id)->where('verified', false)->onlyTrashed()->count();
            $pendingCount = \App\Models\Thesis::whereRelation('program', 'college_id', auth()->user()->college_id)->where('verified', false)->count();
        @endphp
        @if($rejectedCount > 0)
        <span class="badge badge-danger">Rejected: {{$rejectedCount}} </span>  
        @endif
        @if($pendingCount> 0)
        <span class="badge badge-success">Pending: {{$pendingCount}} </span>  
        @endif
    </a>
</li>
@endif --}}
</ul>

{{-- 
@if (auth()->user()->role_id == \App\Models\Role::STUDENT) --}}
<p class="font-weight-bold text-uppercase px-3 small pb-4 mb-0 mt-3 section">Catalogue</p>

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
        <a href="{{route('student.title')}}" class="nav-link @if(\Request::routeIs('student.title'))bg-info text-white @else text-dark bg-light @endif">
            <span class="material-icons">
                title
            </span>
                <small>Title</small>
        </a>
    </li>

    {{-- <li class="nav-item">
        <a href="{{route('student.keywords')}}" class="nav-link @if(\Request::routeIs('student.keywords'))bg-info text-white @else text-dark bg-light @endif">
            <span class="material-icons">
                feed
            </span>
                <small>Keywords</small>
        </a>
    </li> --}}

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

<ul class="nav flex-column bg-white mb-0">
    <li class="nav-item">
        <a href="{{route('account.change-pass')}}" class="nav-link  @if(\Request::routeIs('account.change-pass'))bg-info text-white @else text-dark bg-light @endif">
            <span class="material-icons">
                account_circle
            </span>
            <small>Account</small>
        </a>
    </li>
</ul>
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
