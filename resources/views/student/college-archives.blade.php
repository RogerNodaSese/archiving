@extends('layout.dashboard')

@section('header')
<h2 class="display-5 col-md-10 col-lg-10">Thesis Archives</h2>
@endsection
@section('breadcrumbs')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="/archives">Archives</a></li>
      <li class="breadcrumb-item active" aria-current="page">{{$college->description ?? "College"}}</li>
    </ol>
  </nav>
@endsection
@section('contents')
    @foreach ($college->programs as $program)
    <x-card>
        <x-card.image src="https://image.freepik.com/free-photo/hand-painted-watercolor-background-with-sky-clouds-shape_24972-1095.jpg"></x-card.image>
        <x-card.body>
            <x-card.text class="text-center"><a class="text-dark" href="{{ '/archives'.'/'.$college->slug.'/'.$program->slug }}">{{ $program->description }}</a></x-card.text>
        </x-card.body>
    </x-card>
    @endforeach
@endsection