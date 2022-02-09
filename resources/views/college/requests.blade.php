@extends('layout.dashboard')
@section('header')
    <h2 class="display-5 col-md-9 col-lg-9">Requests</h2>
@endsection

@section('contents')
<table class="table table-hover">
    <caption>Request List</caption>
    <thead>
      <tr>
        <th scope="col">#</th>
        <th scope="col">Title</th>
        <th scope="col">Status</th>
        <th scope="col">College Program</th>
        <th class="text-center" colspan="3" scope="col">Action</th>
      </tr>
    </thead>
    <tbody>
    @forelse ($theses as $thesis)
        <tr>
            <th scope="row">{{$loop->iteration}}</th>
            <td class="font-weight-normal"> {{$thesis->title}} </td>
            @if($thesis->trashed())
            <td class="font-weight-normal text-danger"> Rejected </td>
            @else
            <td class="font-weight-normal text-success"> Pending </td>
            @endif
            <td class="font-weight-normal"> {{$thesis->program->description}} </td>
            <td class=""> 
                <a href="{{route('college.requests.view', [$thesis->id])}}" class="text-primary" data-toggle="tooltip" data-placement="top" title="View"> 
                    <span class="material-icons">
                        visibility
                    </span> 
                </a> 
            </td>
            @if($thesis->trashed())
            <td class=""> 
                <a href="{{ route('college.requests.submit', [$thesis->id]) }}" onclick="event.preventDefault(); resubmit({{$thesis->id}})" class="text-success" data-toggle="tooltip" data-placement="top" title="Re-submit"> 
                    <span class="material-icons">
                        send
                    </span>
                </a> 
            </td>
            @else
            <td class=""> 
                <a style="cursor:no-drop" class="text-muted"> 
                    <span class="material-icons">
                        send
                    </span>
                </a> 
            </td>
            @endif
            <td class=""> 
                <a href="{{ route('requests.delete', [$thesis->id]) }}" onclick="event.preventDefault(); del({{$thesis->id}});" class="text-danger" data-toggle="tooltip" data-placement="top" title="Delete"> 
                    <span class="material-icons">
                        delete
                    </span>
                </a> 
            </td>
        </tr>
        <form id="submit-form{{$thesis->id}}" action="{{ route('college.requests.submit', [$thesis->id]) }}" method="post" class="invisible">
            @method('PUT')
            @csrf   
        </form>
        <form id="delete-form{{$thesis->id}}" action="{{ route('requests.delete', [$thesis->id]) }}" method="post" class="invisible">
            @method('delete')
            @csrf
        </form>
    @empty
    <tr>
        <td colspan="6">
            <div class="d-flex justify-content-center justify-item-center">
                <span>No request submitted, for now.</span>
            </div>
        </td>
    </tr>
    @endforelse
    </tbody>
</table>

@push('scripts')
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="{{ asset('js/verification.js') }}"></script>
    @if(session('deleted'))
        <script>deleted()</script>
    @endif

    @if(session('submitted'))
        <script>submitted()</script>
    @endif
    @endpush
@endsection

