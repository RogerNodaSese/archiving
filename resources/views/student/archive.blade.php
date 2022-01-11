@extends('layout.dashboard')

@section('header')
<h2 class="display-5 col-md-10 col-lg-10">Thesis Archives</h2>
@endsection

@push('styles')
    <style>
        .link:visited{
            color:purple;
        }
        label{
            font-size: 1vw;
        }
        h4{
            font-size: 1.5vw;
        }
        #abs{
            font-size: 1vw;
        }
        @media only screen and (max-width: 600px) {
            h4 {
                font-size: 2.5vw;
            }
            label{
                font-size: 1.6vw;
            }
            #abs{
                font-size: 1.5vw;
            }
        }
    </style>
@endpush
@section('breadcrumbs')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        @if(url()->previous() == route('student.program',[$college->slug,$program->slug]) || url()->previous() == url()->current())
            <li class="breadcrumb-item"><a href="/archives">Archives</a></li>
            <li class="breadcrumb-item"><a href="/archives/{{$college->slug}}">{{$college->description}}</a></li>
            <li class="breadcrumb-item"><a href="/archives/{{$college->slug}}/{{$program->slug}}">{{$program->description}}</a></li>
            <li class="breadcrumb-item active" aria-current="page">Thesis</li>
        @else
            <li class="breadcrumb-item"><a href="{{url()->previous()}}">Back</a></li>
            <li class="breadcrumb-item active" aria-current="page">Thesis</li>
        @endif
    </ol>
  </nav>
@endsection

@section('contents')
<div class="container mt-4">
    <div class="d-flex flex-column">
        <div class="d-flex flex-row">
            <label class="col-4 col-lg-2" for="title">Title:</label>
            <h4 class="col-8 col-lg-10" id="title">{{$thesis->title}}</h4>
        </div>
        <div class="d-flex flex-row mt-4">
            <label class="col-4 col-lg-2" for="author">Author/s:</label>    
            <h4 class="col-8 col-lg-10" id="author">
        @foreach ($thesis->authors as $author)
            {{$author->last_name}}, {{substr($author->first_name, 0,1)}};
        @endforeach
            </h4>
        </div>
        <div class="d-flex flex-row mt-4">
            <label class="col-4 col-lg-2" for="date">Date of issue:</label>
            <h4 class="col-8 col-lg-10" id="date">{{$date['month']}} {{$date['day']}}, {{$date['year']}}</h4>
        </div>
        <div class="d-flex flex-row mt-4">
            <label class="col-4 col-lg-2" for="dept">College Department:</label>
            <h4 class="col-8 col-lg-10" id="dept">{{$thesis->program->college->description}}</h4>
        </div>
        <div class="d-flex flex-row mt-4">
            <label class="col-4 col-lg-2" for="program">College Program:</label>
            <h4 class="col-8 col-lg-10" id="program">{{$thesis->program->description}}</h4>
        </div>
        <div class="d-flex flex-row mt-4">
            <label class="col-4 col-lg-2" for="key">Keyword/s:</label>
            <h4 class="col-8 col-lg-10" id="key">
                @foreach ($thesis->keywords as $keyword)
                    <a class="link" href="/archives/keyword/{{$keyword->description}}">{{$keyword->description}}</a>;
                @endforeach
            </h4>
        </div>
        <div class="d-flex flex-row mt-4">
            <label class="col-4 col-lg-2" for="subj">Subject/s:</label>
            <h4 class="col-8 col-lg-9" id="subj">
                @foreach ($thesis->subjects as $subject)
                    <a class="link" href="{{route('student.subject', $subject->description)}}">{{$subject->description}}</a>;
                @endforeach
            </h4>
        </div>
        <div class="d-flex flex-column mt-4">
            <label class="col-4 col-lg-2" for="abs">Suggested citation:</label>
            <div class="col-12 col-lg-12">
                    <p class="lead text-justify" id="abs">{{$thesis->citation}}</p>           
            </div>
        </div>
        <div class="d-flex flex-column mt-4">
            <label class="col-4 col-lg-2" for="abs">Abstract:</label>
            <div class="col-12 col-lg-12">
                    <p class="lead text-justify" id="abs">{{$thesis->abstract}}</p>           
            </div>
        </div>
    </div>
</div>
@endsection