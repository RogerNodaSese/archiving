@extends('layout.dashboard')

@section('header')
<h2 class="display-5 col-12 col-md-12 col-lg-12 text-center mb-3">{{$thesis->title}}</h2>
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
        p{
            font-weight: 500;
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
            <li class="breadcrumb-item active" aria-current="page">Metadata</li>
        @else
            <li class="breadcrumb-item"><a href="{{url()->previous()}}">Back</a></li>
            <li class="breadcrumb-item active" aria-current="page">Thesis</li>
        @endif
    </ol>
  </nav>
@endsection

@section('contents')
<div class="container mt-4">
    <div class="d-flex flex-column mt-4">
        <div class="d-flex flex-row">
            <div class="col-6 col-md-6 col-lg-6">
                <div class="d-flex flex-column">
                    <label class="col-12 col-lg-12" for="author">Author/s:</label>    
                    <p class="col-12 col-lg-12" id="author">
                        @foreach ($thesis->authors as $author)
                            {{$author->last_name}}, {{substr($author->first_name, 0,1)}};
                        @endforeach
                    </p>
                </div>
            </div>
            <div class="col-6 col-md-6 col-lg-6">
                <div class="d-flex flex-column">
                    <label class="col-12 col-lg-12" for="date">Date of issue:</label>
                    <p class="col-12 col-lg-12" id="date">{{$date['month']}} {{$date['day']}}, {{$date['year']}}</p>
                </div>
            </div>
        </div>
        <div class="d-flex flex-row mt-4">
            <div class="col-6 col-md-6 col-lg-6">
                <div class="d-flex flex-column">
                    <label class="col-12 col-lg-12" for="dept">College Department:</label>
                    <p class="col-12 col-lg-12" id="dept">{{$thesis->program->college->description}}</p>
                </div>
            </div>
            <div class="col-6 col-md-6 col-lg-6">
                <div class="d-flex flex-column">
                    <label class="col-12 col-lg-12" for="program">College Program:</label>
                    <p class="col-12 col-lg-12" id="program">{{$thesis->program->description}}</p>
                </div>
            </div>
        </div>
        <div class="d-flex flex-row mt-4">
            <div class="col-6 col-md-6 col-lg-6">
                <div class="d-flex flex-column">
                    <label class="col-12 col-lg-12" for="key">Keyword/s:</label>
                    <p class="col-12 col-lg-12" id="key">
                        @foreach ($thesis->keywords as $keyword)
                            <a class="link" href="/archives/keyword/{{$keyword->description}}">{{$keyword->description}}</a>;
                        @endforeach
                    </p>
                </div>
            </div>
            <div class="col-6 col-md-6 col-lg-6">
                <div class="d-flex flex-column">
                    <label class="col-12 col-lg-12" for="subj">Subject/s:</label>
                    <p class="col-12 col-lg-12" id="subj">
                        @foreach ($thesis->subjects as $subject)
                            <a class="link" href="{{route('student.subject', $subject->description)}}">{{$subject->description}}</a>;
                        @endforeach
                    </p>
                </div>
            </div>
        </div>

        @if(auth()->user()->isSuperAdministrator() || $thesis->program->college_id == auth()->user()->college_id)
        <div class="d-flex flex-row mt-4">
            <div class="col-6 col-md-6 col-lg-6">
                <div class="d-flex flex-column">
                    <label class="col-12 col-lg-12" for="subj">File:</label>
                    <p class="col-12 col-lg-12" id="subj">
                        <a class="link" href="{{route('file', $thesis->id)}}">{{$thesis->file->description}}.pdf</a>
                    </p>
                </div>
            </div>
            <div class="col-6 col-md-6 col-lg-6">
                <div class="d-flex flex-column">
                    <label class="col-12 col-lg-12" for="subj">File size:</label>
                    <p class="col-12 col-lg-12" id="subj">
                         {{$kb. 'KB'}}
                    </p>
                </div>
            </div>
        </div>
        @endif
        
        <div class="d-flex flex-row mt-4">
            <div class="col-12 col-md-12 col-lg-12">
                <div class="d-flex flex-column">
                    <label class="col-12 col-lg-12" for="abs">Suggested citation:</label>
                    <div class="col-12 col-lg-12">
                        <p class="lead text-justify" id="abs">{{$thesis->citation}}</p>           
                    </div>
                </div>
            </div>
        </div>
       
        <div class="d-flex flex-row mt-4">
            <div class="col-12 col-md-12 col-lg-12">
                <div class="d-flex flex-column">
                    <label class="col-12 col-lg-12" for="abs">Abstract:</label>
                    <div class="col-12 col-lg-12">
                        <p class="lead text-justify" id="abs">{{$thesis->abstract}}</p>           
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection