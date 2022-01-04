<div class="container">
    <div class="col-md-3 col-lg-3 ml-auto">
        <label class="sr-only" for="inlineFormInputGroup">Search</label>
        <div class="input-group mb-2">
          <div class="input-group-prepend">
            <div class="input-group-text">
                <span class="material-icons">
                    search
                </span>
            </div>
          </div>
          <input type="text" class="form-control" wire:model.debounce.500ms="search" placeholder="Search">
        </div>
      </div>
      <div class="d-flex justify-content-center">
        <div wire:loading.class="spinner-border spinner-border-xl"></div>
      </div>
        <table class="table table-striped" wire:loading.class="d-none">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">College</th>
                    <th class="text-center" scope="col">Total Programs</th>
                    <th class="text-center" scope="col">Total Archive/s</th>
                </tr>
            </thead>
            <tbody>
        @forelse ($colleges as $college)
        {{-- {{$college}} --}}
                <tr>
                    <th scope="row">{{$loop->iteration}}</th>
                    <td><a href="{{route('student.college', [$college->slug])}}">{{$college->description}}</a></td>
                    <td class="text-center">{{$college->programs_count}}</td>
                    <td class="text-center">{{$college->programs->sum('theses_count')}}</td>
                </tr>
        @empty
        <tr>
            <td colspan="6">
                <div class="d-flex justify-content-center justify-item-center">
                    <span>No results found!</span>
                </div>
            </td>
        </tr>
        @endforelse
            </tbody>
        </table>
        <div class="d-flex justify-content-center">
            <div wire:loading.class="d-none">
            {{$colleges->links()}}
            </div>
        </div>
    </div>