@extends('layout.dashboard')

@section('header')
<h2 class="display-5 col-md-10 col-lg-10">Welcome {{auth()->user()->first_name}} {{auth()->user()->last_name}}</h2>
<h6 class="display-5 col-md-10 col-lg-10">NEU Archives</h6>
@endsection
@section('contents')
@forelse ($colleges as $college)
<x-card>
    <x-card.image src="https://image.freepik.com/free-photo/hand-painted-watercolor-background-with-sky-clouds-shape_24972-1095.jpg"></x-card.image>
    <x-card.body>
        <x-card.text class="text-center"><a class="text-dark" href="{{ '/archives'.'/'.$college->slug }}">{{ $college->description }}</a></x-card.text>
    </x-card.body>
</x-card>
@empty
    <x-card>
        <x-card.text>EMPTY</x-card.text>
    </x-card>
@endforelse
@endsection