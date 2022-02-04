@extends('layout.dashboard')

@section('header')
<h2 class="display-5 col-md-10 col-lg-10">Thesis Archives</h2>
@endsection

@section('breadcrumbs')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="/archives">Archives</a></li>
      <li class="breadcrumb-item"><a href="/archives/{{$college->slug}}">{{$college->description}}</a></li>
      <li class="breadcrumb-item active" aria-current="page">{{$program->description}}</li>
    </ol>
  </nav>
@endsection

@section('contents')
    @forelse ($theses as $thesis)
    <x-card>
        <x-card.header class="d-flex justify-content-center"> {{$thesis->title}} </x-card.header> 
            <x-card.body style="background:#FFFFFF">
               <x-card.text class="font-weight-normal"> <b>Author/s: </b>
                @foreach ($thesis->authors as $author)
                    {{$author->last_name}}, {{substr($author->first_name, 0, 1)}};
                @endforeach
               <br><b>Date Issue:</b> {{$thesis->date_of_issue}}
               <br><b> Abstract:</b> <br> {{\Illuminate\Support\Str::limit($thesis->abstract, 150)}}
               </x-card.text>
            </x-card.body>
            <a href="{{ '/archives'.'/'.$college->slug.'/'.$program->slug.'/'.$thesis->id }}" class="btn btn-primary">View</a>
    </x-card>
    @empty
      <h1 class="display-4 mt-3">No archives found!</h1>
    @endforelse
@endsection