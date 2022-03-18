@extends('layout.dashboard')

@section('header')
    <h2 class="display-5 col-md-9 col-lg-9">Dashboard</h2>
@endsection
@section('contents')
    <x-card>
        <x-card.header class="d-flex justify-content-center">
            <h2>Total Thesis</h2>
        </x-card.header>
        <x-card.body class="d-flex justify-content-center" style="background-color:#FFFFFF ">
            <div class="row">
                <h3><b>{{ $count['thesis'] }} </b></h3>
            </div>
        </x-card.body>
    </x-card>
    <x-card>
        <x-card.header class="d-flex justify-content-center">
            <h2>Total User</h2>
        </x-card.header>
        <x-card.body class="d-flex justify-content-center" style="background-color:#FFFFFF ">
            <div class="row">
                <h3><b> {{ $count['user'] }} </b></h3>
            </div>
        </x-card.body>
    </x-card>
    <x-card>
        <x-card.header class="d-flex justify-content-center">
            <h2>Total Author</h2>
        </x-card.header>
        <x-card.body class="d-flex justify-content-center" style="background-color:#FFFFFF ">
            <h3><b> {{ $count['author'] }} </b></h3>
        </x-card.body>
    </x-card>
    <x-card>
        <x-card.header class="d-flex justify-content-center">
            <h2>Total Subject</h2>
        </x-card.header>
        <x-card.body class="d-flex justify-content-center" style="background-color:#FFFFFF ">
            <h3><b> {{ $count['subject'] }} </b></h3>
        </x-card.body>
    </x-card>
@endsection

{{-- @section('recent')
<div class="separator"></div>
<h2>Recently Added</h2>
<div class="row text-dark justify-content-center">
    @forelse($count['recent'] as $recent)
    <x-card class="col-sm-12 col-md-12 card m-2">
        <x-card.header class="d-flex justify-content-center">
            <h2>{{ $recent->title }}</h2>
        </x-card.header>
        <x-card.body class="d-flex justify-content-center" style="background-color:#FFFFFF ">
            <h3><b> {{ $recent->title }} </b></h3>
        </x-card.body>
    </x-card>
    @empty
    @endforelse
</div>
@endsection --}}