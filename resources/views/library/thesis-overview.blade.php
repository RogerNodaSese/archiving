@extends('layout.dashboard')

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

@section('header')
    <h2 class="display-5 col-md-9 col-lg-9">Metadata</h2>
@endsection

@section('breadcrumbs')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="{{route('library.requests')}}">Archive Requests</a></li>
      <li class="breadcrumb-item active" aria-current="page">{{$thesis->title}}</li>
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
        @if(auth()->user()->isSuperAdministrator() || $thesis->program->college_id == auth()->user()->college_id)
        <div class="d-flex flex-row mt-4">
            <label class="col-4 col-lg-2" for="subj">File:</label>
            <h4 class="col-8 col-lg-9" id="subj">
                    <a class="link" href="{{route('file', $thesis->id)}}">{{$thesis->file->description}}</a>
            </h4>
        </div>
        @endif
        <div class="d-flex flex-column mt-4">
            <label class="col-12 col-lg-12" for="abs">Suggested citation:</label>
            <div class="col-12 col-lg-12">
                    <p class="lead text-justify" id="abs">{{$thesis->citation}}</p>           
            </div>
        </div>
        <div class="d-flex flex-column mt-4">
            <label class="col-12 col-lg-12" for="abs">Abstract:</label>
            <div class="col-12 col-lg-12">
                    <p class="lead text-justify" id="abs">{{$thesis->abstract}}</p>           
            </div>
        </div>
    </div>
</div>
@endsection