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
                    <th scope="col">Keyword</th>
                    <th scope="col">Total</th>
                </tr>
            </thead>
            <tbody>
        @forelse ($keywords as $keyword)
                <tr>
                    <th scope="row">{{$loop->iteration}}</th>
                    <td><a href="{{route('student.keyword', [$keyword->description])}}">{{$keyword->description}}</a></td>
                    <td>{{$keyword->theses_count}}</td>
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
            {{$keywords->links()}}
            </div>
        </div>
    </div>