@extends('layout.app')

@section('content')

<div class="container mt-3 w-50">
    <form action="{{ route('verification.send') }}" method="POST">
        @csrf
        @if (session('message'))
        <div class="alert alert-info">
          {{ session('message') }}
      </div>
        @endif
    <div class="card">
        <div class="card-header">Verify your email address. Click <a href="{{route('logout')}}" onclick="event.preventDefault(); document.getElementById('logout').submit()">here</a> to go back.</div>
        <div class="card-body">Before proceeding, please check your email for a verification link. If you did not receive the email,<div class="spinner-border text-success spinner-border-sm position-absolute ml-5 mt-2 invisible"></div> <button class="btn btn-link" id="btn" type="submit">click here to resend</button></div>
    </div>
    </form>
    <form id="logout" action="{{ route('logout') }}" method="post" class="invisible">
      @csrf
  </form>
</div>
<script>
    $(document).ready(function() {
      $("form").submit(function() {
        $(".spinner-border").removeClass("invisible");
        $(".btn").hide();
      });
    });
    </script>
@endsection