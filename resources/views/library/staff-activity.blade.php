@extends('layout.dashboard')

@section('header')
    <h2 class="display-5 col-md-9 col-lg-9">Activity Logs</h2>
@endsection
@section('contents')
<table class="table table-striped">
    <thead>
      <tr>
        <th scope="col">Name</th>
        <th scope="col">Total thesis added today</th>
        <th scope="col">Total added thesis</th>
        <th scope="col">Action</th>
      </tr>
    </thead>
    <tbody>
      @foreach($staffAddedToday as $staff)
        <tr>
            <td>{{$staff->first_name}} {{$staff->last_name}}</td>
            <td>{{$staff->theses_added_today}}</td>
            <td>{{$staff->theses_count}}</td>
            <td><a href="{{route('library.staff.log', $staff->id)}}">View</a></td>
        </tr>
      @endforeach
    </tbody>
  </table>
  <div class="container d-flex justify-content-center">
    {{$staffAddedToday->links()}}
</div>
</div>
@endsection

