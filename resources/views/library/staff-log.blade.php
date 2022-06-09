@extends('layout.dashboard')

@section('header')
    <h2 class="display-5 col-md-9 col-lg-9">{{$user->first_name}} {{$user->last_name}} Logs</h2>
@endsection
@section('contents')
<table class="table table-striped">
    <thead>
      <tr>
        <th scope="col">Accession Number</th>
        <th scope="col">Title</th>
        <th scope="col">Date & Time added</th>
        <th scope="col">Program</th>
        <th scope="col">Action</th>
      </tr>
    </thead>
    <tbody>
        @foreach($theses as $thesis)
            <tr>
                <td>{{$thesis->id}}</td>
                <td>{{$thesis->title}}</td>
                <td>{{$thesis->created_at}}</td>
                <td>{{$thesis->program->description}}</td>
                <td><a href="{{ '/archives'.'/'.$thesis->program->college->slug.'/'.$thesis->program->slug.'/'.$thesis->id }}">View</a></td>
            </tr>
        @endforeach
    </tbody>
  </table>
  <div class="container d-flex justify-content-center">
    {{$theses->links()}}
</div>
</div>
@endsection

