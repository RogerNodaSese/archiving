@extends('layout.dashboard')

@section('header')
<h2 class="display-5 col-md-10 col-lg-10">Hello, {{auth()->user()->first_name}} {{auth()->user()->last_name}}</h2>
@endsection
@section('contents')
<x-card>
    <x-card.header class="d-flex justify-content-center">
        <h2>Number of Thesis Added</h2>
    </x-card.header>
    <x-card.body class="d-flex justify-content-center" style="background-color:#FFFFFF ">
        <div class="row">
            <h3><b>{{ $total }} </b></h3>
        </div>
    </x-card.body>
</x-card>
<x-card>
    <x-card.header class="d-flex justify-content-center">
        <h2>Number of Added Today</h2>
    </x-card.header>
    <x-card.body class="d-flex justify-content-center" style="background-color:#FFFFFF ">
        <div class="row">
            <h3><b>{{ $recentAdded }} </b></h3>
        </div>
    </x-card.body>
</x-card>
<div class="container mt-5 border rounded p-4">
<h2 class="display-5 col-md-10 col-lg-10">Thesis/Capstone Added Today</h2>
<table class="table table-striped">
    <thead>
      <tr>
        <th scope="col">Accession #</th>
        <th scope="col">Title</th>
        <th scope="col">College Program</th>
        <th scope="col">Action</th>
      </tr>
    </thead>
    <tbody>
      @foreach($recent as $thesis)
        <tr>
            <td>{{$thesis->id}}</td>
            <td>{{$thesis->title}}</td>
            <td>{{$thesis->program->description}}</td>
            <td><a href="{{route('student.archive',[$thesis->program->college->slug,$thesis->program->slug,$thesis->id])}}" class="text-primary" data-toggle="tooltip" data-placement="top" title="View">View </a></td>
        </tr>
      @endforeach
    </tbody>
  </table>
  <div class="container d-flex justify-content-center">
    {{$recent->links()}}
</div>
</div>

<div class="container mt-5 border rounded p-4">
  <h2 class="display-5 col-md-10 col-lg-10">Thesis/Capstone Added List</h2>
  <table class="table table-striped">
      <thead>
        <tr>
          <th scope="col">Accession #</th>
          <th scope="col">Title</th>
          <th scope="col">College Program</th>
          <th scope="col">Action</th>
        </tr>
      </thead>
      <tbody>
        @foreach($addedThesis as $thesis)
          <tr>
              <td>{{$thesis->id}}</td>
              <td>{{$thesis->title}}</td>
              <td>{{$thesis->program->description}}</td>
              <td><a href="{{route('student.archive',[$thesis->program->college->slug,$thesis->program->slug,$thesis->id])}}" class="text-primary" data-toggle="tooltip" data-placement="top" title="View">View </a></td>
          </tr>
        @endforeach
      </tbody>
    </table>
    <div class="container d-flex justify-content-center">
      {{$addedThesis->links()}}
  </div>
  </div>
@endsection