@extends('layout.dashboard')

@section('header')
<h2 class="display-5 col-md-10 col-lg-10">You've searched for {{\Str::ucfirst($slug)}}</h2>
@endsection

@section('breadcrumbs')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="{{route('student.index')}}">Archives</a></li>
      <li class="breadcrumb-item"><a href="{{route('student.subjects')}}">Subject</a></li>
      <li class="breadcrumb-item active" aria-current="page">{{$slug}}</li>
    </ol>
</nav>
@endsection
@section('contents')
@forelse ($theses as $thesis)
    <x-card>
        <x-card.header>
            {{$thesis->title}}
        </x-card.header>
        <x-card.body style="background:#FFFFFF">
            <x-card.text class="font-weight-normal"> <b>Author/s: </b>
                @foreach ($thesis->authors as $author)
                    {{$author->last_name}}, {{substr($author->first_name, 0, 1)}};
                @endforeach
                <br><b>Place of Publication:</b> {{ $thesis->place_of_publication}}
               <br><b>Publication Date:</b> {{ \Carbon\Carbon::createFromFormat('Y-m', $thesis->date_of_publication)->format('F Y')}}
               <br><b> Abstract:</b> <br> {{\Illuminate\Support\Str::limit($thesis->abstract, 150)}}
               </x-card.text>
        </x-card.body>
        <a href="{{route('student.archive',[$thesis->program->college->slug,$thesis->program->slug,$thesis->id])}}" class="btn btn-primary">View</a>
    </x-card>   
@empty
    <h1 class="display-4 mt-3">No archives found!</h1>
@endforelse
<div class="container d-flex justify-content-center">
    {{$theses->links()}}
</div>
@endsection