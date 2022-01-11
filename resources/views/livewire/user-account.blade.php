<div class="container mt-5">
    <form wire:submit.prevent="create">
        @csrf
        
    <div class="form-group row mb-2">
        <label for="staticEmail" class="col-sm-2 col-form-label">
            Name
        </label>
        <div class="col-sm-4 d-inline mb-2">
          <input type="text" class="form-control" wire:model="firstname" placeholder="Firstname">
          @error('firstname')
          <small class="text-danger">{{ $message }}</small>
          @enderror
        </div>
        <div class="col-sm-4 d-inline mb-2">
          <input type="text" class="form-control" wire:model="lastname" id="staticEmail" placeholder="Lastname">
          @error('lastname')
          <small class="text-danger">{{ $message }}</small>
          @enderror
        </div>
    </div>
    <div class="form-group row mb-2">
        <label for="inputPassword" class="col-sm-2 col-form-label">Email</label>
        <div class="col-sm-8 mb-2">
          <input type="email" class="form-control" wire:model="email" id="inputPassword" placeholder="ex. computerstudies@neu.edu.ph">
          @error('email')
          <small class="text-danger">{{ $message }}</small>
          @enderror
        </div>
    </div>
    <div class="form-group row mb-2">
        <label for="inputPassword" class="col-sm-2 col-form-label">College</label>
        <div class="col-sm-8 mb-2">
            <select class="custom-select" id="college" wire:model = "college">
                <option value="">--College Department--</option>
                @forelse ($colleges as $college)
                <option value="{{$college->id}}">{{$college->description}}</option>
                @empty
                <option value="">No colleges</option>
                @endforelse
            </select>
            @error('college')
            <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>
    </div>
    <div class="form-group row mb-2">
        <label for="password" class="col-sm-2 col-form-label">Password</label>
        <div class="col-sm-8 mb-2">
          <input type="password" class="form-control" wire:model="password" name="password" id="password" placeholder="••••••••">
          @error('password')
          <small class="text-danger">{{ $message }}</small>
          @enderror
        </div>
    </div>
    <div class="form-group row mb-2">
        <label for="password_confirmation" class="col-sm-2 col-form-label">Confirm password</label>
        <div class="col-sm-8 mb-2">
          <input type="password" class="form-control" name="password_confirmation" wire:model="password_confirmation"  id="password_confirmation" placeholder="••••••••">
          @error('password')
          <small class="text-danger">{{ $message }}</small>
          @enderror
        </div>
    </div>
    <div class="col-md-4 col-lg-2 form-group ml-auto" style="">
        <button type="submit"  class="btn btn-primary form-control">CREATE</button>
    </div>
</form>
</div>