<div class="container mt-5">
  @if(session('message'))
    <div class="d-flex justify-content-center text-center">
        <div class="alert alert-danger w-50">
            <h3>{{session('message')}}</h3>
        </div>
    </div>
    @endif
    <form wire:submit.prevent="addThesis" method="POST">
      @csrf
      <div class="form-group row mb-2">
        <label for="inputPassword" class="col-sm-2 col-form-label">Title</label>
        <div class="col-sm-8 mb-2">
          <input type="text" wire:model="title" class="form-control @error('title') border border-danger @enderror" wire:model.lazy="title" name="title" id="inputPassword" placeholder="Thesis title">
          @error('title')
              <small class="text-danger">{{ $message }}</small>
          @enderror
        </div>
      </div>
      {{-- <div class="form-group row mb-2">
        <label for="inputPassword" class="col-sm-2 col-form-label">Accession number</label>
        <div class="col-sm-8 mb-2">
          <input type="text" class="form-control @error('accession') border border-danger @enderror" wire:model.lazy="accession" name="accession" id="inputPassword" placeholder="Thesis accession number">
          @error('accession')
              <small class="text-danger">{{ $message }}</small>
          @enderror
        </div>
      </div> --}}
        <div>
          @foreach ($authors as $index => $author)
          <div class="form-group row mb-2">
              <label for="staticEmail" class="col-sm-2 col-form-label">
                  @if ($index == 0)
                  Author/s
                  @endif 
              </label>
              <div class="col-sm-3 d-inline mb-2">
                <input type="text" wire:key="{{$loop->index}}" class="form-control @error('authors.'.$index.'.lastname') border border-danger @enderror" id="staticEmail"  wire:model.lazy="authors.{{$index}}.lastname" placeholder="Lastname">
                @error('authors.'.$index.'.lastname')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
              </div>
              <div class="col-sm-3 d-inline mb-2">
                <input type="text" wire:key="{{$loop->index}}" class="form-control @error('authors.'.$index.'.firstname') border border-danger @enderror " id="staticEmail" wire:model.lazy="authors.{{$index}}.firstname" placeholder="Firstname">
                @error('authors.'.$index.'.firstname')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
              </div>
              {{-- MIDDLE NAME --}}
              <div class="col-sm-2 d-inline mb-2">
                <input type="text" wire:key="{{$loop->index}}" class="form-control @error('authors.'.$index.'.middlename') border border-danger @enderror" id="staticEmail"  wire:model.lazy="authors.{{$index}}.middlename" placeholder="Middle initial">
                @error('authors.'.$index.'.middlename')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
              </div>
              @if ($index == 0)
              <div class="col-md-4 col-lg-2 form-group ml-auto">
                  <a class="btn btn-link border form-control" wire:click.debounce.250ms="addAuthor">+ Add Author</a>
              </div>
              @endif
              @if ($index > 0)
              <div class="col-md-4 col-lg-2 form-group ml-auto">
                  <a class="btn btn-link border text-danger form-control" wire:click.prevent="removeAuthor({{$index}})">Remove</a>
              </div>
              @endif
            </div>
          
          @endforeach
          </div>
          <div class="form-group row mb-2">
            <label for="inputPassword" class="col-sm-2 col-form-label">Publisher</label>
            <div class="col-sm-8 mb-2">
              <input type="text" wire:model="publisher" class="form-control @error('publisher') border border-danger @enderror" wire:model.lazy="publisher" name="publisher" id="inputPassword" placeholder="Ex. New Era University">
              @error('publisher')
                  <small class="text-danger">{{ $message }}</small>
              @enderror
            </div>
          </div>
        <div class="form-group row mb-2">
            <label for="staticEmail" class="col-sm-2 col-form-label">Date of publication</label>
            <div class="col-sm-4 d-inline mb-2">
                <select class="custom-select @error('month') border border-danger @enderror" wire:model="month" id="month">
                    <option value="" selected data-default>Month</option>
                    @foreach ($months as $index => $month)
                        <option value="{{$index}}">{{$month}}</option>
                    @endforeach
                </select>
                @error('month')
                <small class="text-danger">{{ $message }}</small>
            @enderror
            </div>
            {{-- <div class="col-sm-2 d-inline mb-2">
                <select class="custom-select @error('day') border border-danger @enderror" wire:model="day" id="day">
                    <option value="" selected data-default>Day</option>
                    @foreach ($days as $day)
                        <option value="{{$day}}">{{$day}}</option>
                    @endforeach
                </select>
                @error('day')
                <small class="text-danger">{{ $message }}</small>
            @enderror
            </div> --}}
            <div class="col-sm-4 d-inline mb-2">
                <select class="custom-select @error('year') border border-danger @enderror" wire:model="year" id="year">
                    <option value="" selected data-default>Year</option>
                    @foreach ($years as $year)
                        <option value="{{$year}}">{{$year}}</option>
                    @endforeach
                </select>
                @error('year')
                <small class="text-danger">{{ $message }}</small>
            @enderror
            </div>
        </div>
        <div class="form-group row mb-2">
            <label for="inputPassword" class="col-sm-2 col-form-label">College</label>
            <div class="col-sm-8 mb-2">
                <select class="custom-select @error('college') border border-danger @enderror" wire:model="college" id="college">
                    <option value="">--College Department--</option>
                    @foreach ($colleges as $college) 
                        <option value="{{$college->id}}" id="{{$college->id}}">{{$college->description}}</option>
                    @endforeach
                </select>
              @error('college')
                  <small class="text-danger">{{ $message }}</small>
              @enderror
            </div>
          </div>
          <div class="form-group row mb-2">
            <label for="inputPassword" class="col-sm-2 col-form-label">Program</label>
            <div class="col-sm-8 mb-2">
              <select class="custom-select @error('program') border border-danger @enderror" wire:model="program" id="program">
                <option value="">--College Programs--</option>
                @foreach ($programs as $program) 
                    <option value="{{$program->id}}">{{$program->description}}</option>
                @endforeach
              </select>
              @error('program')
              <small class="text-danger">{{ $message }}</small>
          @enderror
            </div>
          </div>
          <div class="form-group row mb-2">
            <label for="inputPassword" class="col-sm-2 col-form-label">Subject</label>
            <div class="col-sm-8 mb-2">
              <input type="text" class="form-control @error('subject') border border-danger @enderror" wire:model.lazy="subject" name="subject" id="inputPassword" placeholder="Thesis subject">
              @error('subject')
                  <small class="text-danger">{{ $message }}</small>
              @enderror
            </div>
          </div>
          {{-- <div class="form-group row mb-2">
            <label for="inputPassword" class="col-sm-2 col-form-label">Keyword/s</label>
            <div class="col-sm-8 mb-2">
              <input type="text" class="form-control @error('keyword') border border-danger @enderror" wire:model.lazy="keyword" name="keywords" id="inputPassword" placeholder="ex: Archiving, Management">
              <small class="blockquote-footer">Comma seperated value</small>
              @error('keyword')
                  <small class="text-danger">{{ $message }}</small>
              @enderror
            </div>
          </div> --}}
          <div class="form-group row mb-2">
            <label for="inputPassword" class="col-sm-2 col-form-label">Suggested citation</label>
            <div class="col-sm-8 mb-2">
              <textarea class="form-control @error('citation') border border-danger @enderror" rows="3" wire:model.lazy="citation" name="citation" id="inputPassword"></textarea>
              @error('citation')
                  <small class="text-danger">{{ $message }}</small>
              @enderror
            </div>
          </div>
          <div class="form-group row mb-2">
            <label for="inputPassword" class="col-sm-2 col-form-label">Abstract</label>
            <div class="col-sm-8 mb-2">
              <textarea class="form-control @error('abstract') border border-danger @enderror" rows="5" wire:model.lazy="abstract" name="abstract" id="inputPassword"></textarea>
              @error('abstract')
                  <small class="text-danger">{{ $message }}</small>
              @enderror
            </div>
          </div>
          <div class="form-group row">
            <label for="inputPassword" class="col-sm-2 col-form-label">File</label>
            <div class="col-10 col-md-10 col-lg-10">
              <input type="file" class="form-control-file col-sm-4" style="margin-left:-15px;" wire:model="file" name="thesis" id="inputPassword">
              <div wire:loading wire:target="file" class="spinner-grow text-primary" role="status">
                <span class="sr-only">Loading...</span>
              </div>  
              @error('file')
                <small class="text-danger col-sm-4" style="margin-left:-15px;">{{ $message }}</small>
              @enderror
            </div>
            </div>
            <div class="col-md-4 col-lg-2 form-group ml-auto" style="">
                <button type="submit" wire:loading.attr="disabled" wire:target="file" class="btn btn-primary form-control" id="inputPassword">SUBMIT</button>
              </div>
            </div>
          </div>
          
        </div>
      </form>
</div>
