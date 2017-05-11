<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>
    <link href="{{ asset("/css/print.css") }}" rel="stylesheet">
    @stack("styles")

</head>
<body>
    <div id="app">
        @yield('content')
    </div>

    @stack("scripts")
</body>
</html>
