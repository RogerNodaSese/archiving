@extends('layout.dashboard')

@section('header')
<h2 class="display-5 col-md-10 col-lg-10">{{$college->description ?? "HEADER"}}</h2>
@endsection
@section('contents')
    <x-card>
        <x-card.header>
            Total Program/s
        </x-card.header>
        <x-card.body style="background-color:#FFFFFF ">
            <x-card.text class="d-flex justify-content-center">{{$programCount}}</x-card.text>
        </x-card.body>
    </x-card>
@endsection