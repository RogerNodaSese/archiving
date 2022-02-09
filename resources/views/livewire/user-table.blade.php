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
    {{-- START --}}
    <div class="d-flex flex-row">
      <div class="col-6 col-md-6 col-lg-6">
    <div class="custom-control custom-switch">
      <input type="radio" class="custom-control-input" wire:model="role" value="1" id="customSwitch1">
      <label class="custom-control-label" for="customSwitch1">Admin</label>
    </div>
      </div>
    <div class="custom-control custom-switch">
      <div class="col-6 col-md-6 col-lg-6">
      <input type="radio" class="custom-control-input" wire:model="role" value="2" id="customSwitch2">
      <label class="custom-control-label" for="customSwitch2">Student</label>
      </div>
    </div>
  </div>
  {{-- END --}}
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
            <th scope="col">Department</th>
            <th scope="col">Role</th>
            <th scope="col">Verified</th>
          </tr>
        </thead>
        <tbody>
    @forelse ($users as $user)
        <tr>
            <td>{{$user->first_name}}</td>
            <td>{{$user->last_name}}</td>
            <td>{{$user->email}}</td>
            @if (!empty($user->college->description))
            <td>{{$user->college->description}}</td>
            @elseif($user->role_id == \App\Models\Role::SUPER_ADMIN)
            <td>Library</td>
            @else
            <td>N/A</td>
            @endif
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
