@extends('layout.dashboard')

@section('header')
    <h2 class="display-5 col-md-9 col-lg-9">Library</h2>
@endsection
@section('contents')
    <x-card>
        <x-card.header class="d-flex justify-content-center">
            <h2>Total Thesis</h2>
        </x-card.header>
        <x-card.body class="d-flex justify-content-center" style="background-color:#FFFFFF ">
            <div class="row">
                <p class="col-6" style="font-size: 1rem"><b>Verified: </b>{{$count['thesisVerifiedCount']}}</p>
                <p class="col-6" style="font-size: 1rem"><b>Not verified: </b>{{$count['thesisNotVerifiedCount']}}</p>
                <h3 class="col-12"><b>Total: {{$count['thesisCount']}}</b></h3>
            </div>
        </x-card.body>
    </x-card>
    <x-card>
        <x-card.header class="d-flex justify-content-center">
            <h2>Total User</h2>
        </x-card.header>
        <x-card.body class="d-flex justify-content-center" style="background-color:#FFFFFF ">
            <div class="row">
                <p class="col-6" style="font-size: 1rem"><b>Admin: </b>{{$count['collegeCount']}}</p>
                <p class="col-6" style="font-size: 1rem"><b>Student: </b>{{$count['studentCount']}}</p>
                <h3 class="col-12"><b>Total: {{$count['userCount']}}</b></h3>
            </div>
        </x-card.body>
    </x-card>
    <x-card>
        <x-card.header class="d-flex justify-content-center">
            <h2>Total Author</h2>
        </x-card.header>
        <x-card.body class="d-flex justify-content-center" style="background-color:#FFFFFF ">
            <h3><b>{{$count['authorCount']}}</b></h3>
        </x-card.body>
    </x-card>
@endsection