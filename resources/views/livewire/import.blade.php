<div class="container">
       @if(session()->has('failure'))
        <table class="table table-bordered table-danger">
            <tr>
                <th>Row</th>
                <th>Attribute</th>
                <th>Errors</th>
                <th>Value</th>
            </tr>
            @foreach(session()->get('failure') as $failure)
                <tr>
                    <td>{{ $failure->row() }}</td>
                    <td> {{ ucwords(\Illuminate\Support\Str::replace('_',' ',$failure->attribute())) }}</td>
                    <td>
                        <ul>
                            @foreach( $failure->errors() as $error )
                                <li> {{ $error }} </li>
                            @endforeach
                        </ul>
                    </td>
                    <td> {{ $failure->values()[$failure->attribute()] ?? "This error is caused by changing the column names. Please revert it back to original attribute name. " }} </td>
                </tr>
            @endforeach
        </table>
    @endif
<div class="d-flex justify-content-center">
    <x-card class="col-sm-8 col-md-8 card m-2">
        <x-card.header>Import Excel</x-card.header>
        @error('file') <span class="text-danger text-center">{{ $message }}</span> @enderror
            @if(session()->has('success'))
            <x-card.body style="background:#ffffff;">
                <div class="alert alert-success text-center" role="alert">
                    {{ session()->get('success') }}
                </div>
            </x-card.body>
            @endif
        <x-card.body style="background:#ffffff;" class="d-flex justify-content-center">
            <form wire:submit.prevent="store" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <span wire:loading.class="spinner-border spinner-border-sm"></span>
                    <input type="file" wire:model="file"/>
                    <button type="submit" wire:loading.attr="disabled" class="btn btn-primary btn-sm ml-auto">Import</button>
                </div>
            </form>
        </x-card.body>
    </x-card>
</div>
</div>