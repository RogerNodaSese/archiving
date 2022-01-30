<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{env("APP_NAME")}}</title>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <script src="{{ asset('js/app.js') }}" defer></script>
    <link rel="icon" href="https://neu.edu.ph/main/assets/images/NEU_LOGO.png">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
     @stack('styles')
</head>
<body>
    @yield('content')
    @stack('scripts')
</body>
</html>