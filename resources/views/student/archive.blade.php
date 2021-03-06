@extends('layout.dashboard')

@section('header')
<h2 class="display-5 col-12 col-md-12 col-lg-12 text-center mb-3">{{$thesis->title}}</h2>
@if(auth()->user()->isAdministrator())
<h5 class="added-by col-12 col-md-12 col-lg-12 text-center text-muted">Archived by: <span class="added-by">{{$thesis->user->first_name}} {{$thesis->user->last_name}}</span></h5>
@endif
@endsection

@section('edit')
    <a href="{{route('library.thesis.edit', [$thesis->id])}}" class="btn btn-primary float-right mr-2" id="inputPassword">Edit Archive</a>
@endsection
@push('styles')
    <style>
        .added-by{
            font-size: .9rem;
        }
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
        @media only screen and (max-width: 800px) {
            .flex-row{
                display: flex !important;
                flex-direction: column !important;
            }
            p{
                font-size: 2.5vw;
            }
            h4 {
                font-size: 2.5vw;
            }
            label{
                font-size: 1.6vw;
                margin-top: 4%; 
            }
            #abs{
                font-size: 1.5vw;
            }
            .page-content{
                padding: 0 !important;
            }
            .content{
                box-shadow: 0px 0px !important ;
                border-radius: 0px !important;
                /* background: #ffffff !important; */
            }
        }
    </style>
@endpush
@section('breadcrumbs')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        @if(url()->previous() == route('student.program',[$college->slug,$program->slug]) || url()->previous() == url()->current() || url()->previous() == route('library.thesis.edit', [$thesis->id]))
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
            <div class="col-12 col-md-6 col-lg-6">
                <div class="d-flex flex-column">
                    <label class="col-12 col-lg-12" for="author">Author/s:</label>    
                    <p class="col-12 col-lg-12" id="author">
                        @foreach ($thesis->authors as $author)
                            {{$author->last_name}}, {{$author->first_name}};
                        @endforeach
                    </p>
                </div>
            </div>
            <div class="col-12 col-md-6 col-lg-6">
                <div class="d-flex flex-column">
                    <label class="col-12 col-lg-12" for="date">Publisher:</label>
                    <p class="col-12 col-lg-12" id="date">{{ $thesis->publisher }}</p>
                </div>
            </div>
        </div>
        
        <div class="d-flex flex-row mt-4">
            <div class="col-12 col-md-6 col-lg-6">
                <div class="d-flex flex-column">
                    <label class="col-12 col-lg-12" for="abs">Publication Date</label>
                    <div class="col-12 col-lg-12">
                        <p class="lead text-justify" id="abs">{{$date}}</p>           
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-6 col-lg-6">
                <div class="d-flex flex-column">
                    <label class="col-12 col-lg-12" for="abs">Place of Publication</label>
                    <div class="col-12 col-lg-12">
                        <p class="lead text-justify" id="abs">{{$thesis->place_of_publication}}</p>           
                    </div>
                </div>
            </div>
        </div>
        
        <div class="d-flex flex-row mt-4">
            <div class="col-12 col-md-6 col-lg-6">
                <div class="d-flex flex-column">
                    <label class="col-12 col-lg-12" for="dept">College Department:</label>
                    <p class="col-12 col-lg-12" id="dept">{{$thesis->program->college->description}}</p>
                </div>
            </div>
            <div class="col-12 col-md-6 col-lg-6">
                <div class="d-flex flex-column">
                    <label class="col-12 col-lg-12" for="program">Program:</label>
                    <p class="col-12 col-lg-12" id="program">{{$thesis->program->description}}</p>
                </div>
            </div>
        </div>
        <div class="d-flex flex-row mt-4">
            {{-- <div class="col-6 col-md-6 col-lg-6">
                <div class="d-flex flex-column">
                    <label class="col-12 col-lg-12" for="key">Keyword/s:</label>
                    <p class="col-12 col-lg-12" id="key">
                        @foreach ($thesis->keywords as $keyword)
                            <a class="link" href="/archives/keyword/{{$keyword->description}}">{{$keyword->description}}</a>;
                        @endforeach
                    </p>
                </div>
            </div> --}}
            <div class="col-12 col-md-6 col-lg-6">
                <div class="d-flex flex-column">
                    <label class="col-12 col-lg-12" for="subj">Subject/s:</label>
                    <p class="col-12 col-lg-12" id="subj">
                        @foreach ($thesis->subjects as $subject)
                            <a class="link" href="{{route('student.subject', $subject->description)}}">{{$subject->description}}</a>;
                        @endforeach
                    </p>
                </div>
            </div>

            @if(!is_null($thesis->file))
            <div class="col-12 col-md-6 col-lg-6">
                <div class="d-flex flex-column">
                    <label class="col-12 col-lg-12" for="file">File:</label>
                    <p class="col-12 col-lg-12" id="file">
                        <a class="link" href="{{route('file', $thesis->id)}}">{{$thesis->file->description}}.pdf</a>
                    </p>
                </div>
            </div>
            
            @elseif(is_null($thesis->file) && auth()->user()->isAdministrator())
            <div class="col-12 col-md-6 col-lg-6">
                <div class="d-flex flex-column">
                    <label class="col-12 col-lg-12" for="file">File:</label>
                    <p class="col-12 col-lg-12 text-danger" id="file">
                        No file found
                        <button type="button" data-toggle="modal" data-target="#open" class="btn btn-success btn-sm">Upload</button>
                        <form action="{{route('archives.update', $thesis->id)}}" method="POST" enctype="multipart/form-data">
                            @method('PUT')
                            @csrf
                        <div class="modal fade" id="open" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered" role="document">
                                <div class="modal-content">
                                  <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLongTitle">Upload PDF document</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                      <span aria-hidden="true">&times;</span>
                                    </button>
                                  </div>
                                  <div class="modal-body">
                                   <input type="file" name="file" class="form-control-file"/>
                                   <span class="text-danger"> @error('file') {{ $message }} @enderror</span>
                                  </div>
                                  <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-success">Upload</button>
                                  </div>
                                </div>
                            </div>
                        </div>
                    </form>
                    </p>
                </div>
            </div>
            @else
            <div class="col-12 col-md-6 col-lg-6">
                <div class="d-flex flex-column">
                    <label class="col-12 col-lg-12" for="file">File:</label>
                    <p class="col-12 col-lg-12 text-danger" id="file">
                        No file found
                    </p>
                </div>
            </div>
            @endif
        </div>
        {{-- @if(auth()->user()->isSuperAdministrator() || $thesis->program->college_id == auth()->user()->college_id)
        <div class="d-flex flex-row mt-4">
            <div class="col-12 col-md-6 col-lg-6">
                <div class="d-flex flex-column">
                    <label class="col-12 col-lg-12" for="size">File size:</label>
                    <p class="col-12 col-lg-12" id="size">
                         {{$kb. 'KB'}}
                    </p>
                </div>
            </div>
        </div>
        @endif --}}

        <div class="d-flex flex-row mt-4">
            <div class="col-12 col-md-12 col-lg-12">
                <div class="d-flex flex-column">
                    <label class="col-12 col-lg-12" for="abs">Suggested Citation:</label>
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