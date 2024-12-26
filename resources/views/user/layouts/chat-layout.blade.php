<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ isset($title) ? $title . ' | ' . env('APP_NAME') : env('APP_NAME') }}</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @include('user.layouts.links')
    @yield('css')
    @stack('css')
</head>

<body>
    @yield('content')

    <div class="loader-mask" id="loader">
        <div class="loader"></div>
    </div>

    @include('user.layouts.scripts')
    @yield('js')
    @stack('js')
</body>

</html>
