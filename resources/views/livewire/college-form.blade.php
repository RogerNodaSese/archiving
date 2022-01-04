<div class="container mt-5">
    <form wire:submit.prevent="addCollege" method="POST">
      @csrf
        <div>
            <div class="form-group row mb-2">
              <label for="staticEmail" class="col-4 col-md-2 col-lg-2 col-form-label">
                    College name
              </label>
              <div class="col-8 col-md-8 col-lg-8 d-inline mb-2">
                <input type="text" class="form-control" wire:model.debounce.250ms="collegeName" id="staticEmail"  placeholder="ex. College of Computer Studies">
                @error('collegeName')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
              </div>
            </div>
            <div class="form-group row mb-2">
                <label for="staticEmail" class="col-4 col-md-2 col-lg-2 col-form-label">
                      College slug
                </label>
                <div class="col-8 col-md-8 col-lg-8 d-inline mb-2">
                  <input type="text" class="form-control" wire:model.debounce.250ms="collegeSlug" id="staticEmail"  placeholder="Slug">
                  @error('collegeSlug')
                    <small class="text-danger">{{ $message }}</small>
                  @enderror
                </div>
            </div>
            @foreach ($programs as $index => $program)
            <div class="form-group row mb-2">
              <label for="staticEmail" class="col-4 col-md-2 col-lg-2 col-form-label">
                    @if($index == 0)
                    Program name
                    @endif
              </label>
              <div class="col-8 col-md-8 col-lg-8 d-inline mb-2">
                <input type="text" class="form-control" wire:key="{{$loop->index}}" wire:model.lazy="programs.{{$index}}.description" id="staticEmail"  placeholder="ex. Bachelor of Science in Information Technology">
                @error('programs.'.$index.'.description')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
              </div>
              @if ($index == 0)
              <div class="col-2 col-md-2 col-lg-2 form-group ml-auto">
                <a class="btn btn-link border form-control" wire:click.debounce.250ms="addProgram">+ Program</a>
              </div>
              @endif
              @if ($index > 0)
              <div class="col-md-4 col-lg-2 form-group ml-auto">
                  <a class="btn btn-link border text-danger form-control" wire:click.prevent="removeProgram({{$index}})">Remove</a>
              </div>
              @endif
            </div>
            @endforeach
              <div class="col-12 col-lg-2 form-group ml-auto mt-5" style="">
                <button type="submit" class="btn btn-primary form-control" id="inputPassword">SUBMIT</button>
              </div>
            </div>
          </div>
          
        </div>
      </form>
</div>
