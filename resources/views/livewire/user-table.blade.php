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
      <input type="text" class="form-control" wire:model="search" placeholder="Search">
    </div>
  </div>
<div class="container">
    <div class="d-flex justify-content-center">
        <div wire:loading.class="spinner-border spinner-border-xl"></div>
      </div>
    <table class="table table-striped" wire:loading.class="d-none">
        <thead>
          <tr>
            <th scope="col">Firstname</th>
            <th scope="col">Lastname</th>
            <th scope="col">Email</th>
            <th scope="col">Role</th>
            <th scope="col">Verified</th>
            <th scope="col">Action</th>
          </tr>
        </thead>
        <tbody>
    @forelse ($users as $user)
        <tr>
            <td>{{$user->first_name}}</td>
            <td>{{$user->last_name}}</td>
            <td>{{$user->email}}</td>
            <td>{{$user->role->description}}</td>
            @if ($user->email_verified_at)
            <td>Yes</td>
            @else
            <td>No</td>
            @endif
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
    {{$users->links()}}
</div>
</div>
</div>
