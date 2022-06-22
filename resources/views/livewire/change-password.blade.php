<div class="container mt-5 ml-2">
  <form wire:submit.prevent="changePassword" method="POST">
    @csrf
    <div class="form-group row mb-2">
      <label for="inputPassword" class="col-sm-2 col-form-label">Email</label>
      <div class="col-sm-9 mb-2">
        <input type="text" disabled  class="form-control" name="title" id="inputPassword" value="{{$user->email}}">
      </div>
    </div>
    <div class="form-group row mb-2">
        <label for="inputPassword" class="col-sm-2 col-form-label">Current Password</label>
        <div class="col-sm-9 mb-2">
          <input type="password" wire:model.lazy="currentPassword" class="form-control" name="current_pass" id="inputPassword" placeholder="••••••••" >
          @if(session()->has('incorrect'))
          <small class="text-danger">{{ session('incorrect') }}</small>
          @endif
          @if(session()->has('correct'))
          <small class="text-success">{{ session('correct') }}</small>
          @endif
        </div>
      </div>
    <div class="form-group row mb-2">
        <label for="inputPassword" class="col-sm-2 col-form-label">New Password</label>
        <div class="col-sm-9 mb-2">
          <input type="password" wire:model.lazy="password" class="form-control" name="password" id="inputPassword" placeholder="••••••••" >
        </div>
    </div>
    <div class="form-group row mb-2">
        <label for="inputPassword" class="col-sm-2 col-form-label">Confirm New Password</label>
        <div class="col-sm-9 mb-2">
          <input type="password"  wire:model.lazy="password_confirmation"  class="form-control" name="password_confirmation" id="inputPassword" placeholder="••••••••">
          @error('password')
          <small class="text-danger">{{ $message }}</small>
          @enderror
        </div>
    </div>
    <div class=" col-md-4 col-lg-2 form-group float-right" style="">
      <button type="submit" class="btn btn-success form-control" id="inputPassword">UPDATE</button>
    </div>
  </form>
</div>