@extends('layout.dashboard')

@section('header')
    <h2 class="display-5 col-md-9 col-lg-9">Archives Request</h2>
@endsection

@section('contents')
<table class="table table-hover">
    <caption>Unverified Thesis List</caption>
    <thead>
      <tr>
        <th scope="col">#</th>
        <th scope="col">Title</th>
        <th scope="col">College Department</th>
        <th scope="col">College Program</th>
        <th class="text-center" colspan="3" scope="col">Action</th>
      </tr>
    </thead>
    <tbody>
    @forelse ($theses as $thesis)
        <tr>
            <th scope="row">{{$loop->iteration}}</th>
            <td class="font-weight-normal"> {{$thesis->title}} </td>
            <td class="font-weight-normal"> {{$thesis->program->college->description}} </td>
            <td class="font-weight-normal"> {{$thesis->program->description}} </td>
            <td class="p-1"> <a href="{{route('library.request.view', [$thesis->id])}}" class="btn btn-primary"> View </a> </td>
            <td class="p-1"> <a href="{{ route('library.requests.create', [$thesis->id]) }}" onclick="event.preventDefault(); document.getElementById('submit-form{{$thesis->id}}').submit()" class="btn btn-success"> Verify </button> </td>
            <td class="p-1"> <a href="{{ route('library.requests.delete', [$thesis->id]) }}" onclick="event.preventDefault(); document.getElementById('delete-form{{$thesis->id}}').submit()" class="btn btn-danger"> Decline </a> </td>
        </tr>
        <form id="submit-form{{$thesis->id}}" action="{{ route('library.requests.create', [$thesis->id]) }}" method="post" class="invisible">
            @csrf   
        </form>
        <form id="delete-form{{$thesis->id}}" action="{{ route('library.requests.delete', [$thesis->id]) }}" method="post" class="invisible">
            @method('delete')
            @csrf
        </form>
    @empty
    <tr>
        <td colspan="6">
            <div class="d-flex justify-content-center justify-item-center">
                <span>No request, for now.</span>
            </div>
        </td>
    </tr>
    @endforelse
    </tbody>
</table>

@push('scripts')
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@endpush

@if (session('message'))
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
        
                Toast.fire({
                    icon: 'success',
                    title: '{{session("message")}}',
                })
    </script>
    @endpush
@elseif(session('deleted'))
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
   
           Toast.fire({
               icon: 'error',
               title: '{{session("deleted")}}',
           })
</script>

@endpush
@endif
@endsection
