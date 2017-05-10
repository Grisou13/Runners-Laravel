<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Styles -->
    <link href="{{ asset("/css/app.css") }}" rel="stylesheet">
    <link href="{{ asset("/css/style.css") }}" rel="stylesheet">
    <link href="{{ asset("/css/sweetalert.css") }}" rel="stylesheet">
{{--<link href="{{ asset("/css/theme.css") }}" rel="stylesheet">--}}


@stack("styles")

<!-- Scripts -->
    <script src="{{ asset('/js/axios.min.js') }}"></script>
    <script>
        window.Laravel = <?php echo json_encode([
                'csrfToken' => csrf_token(),
                "token"=>auth()->check() ? auth()->user()->accesstoken : "anonymous",
                "basePath"=>url("/")
        ]); ?> ;

        var api  = window.api = axios.create({
            baseURL: "{!! url("/api") !!}",
            timeout: 5000,
            contentType:"application/json",
            headers: {'X-Access-Token': window.Laravel.token}
        });
    </script>
</head>
<body>
<div id="app">
    @if(isset($message))
        <div class="alert alert-success">
            <span class="glyphicon glyphicon-ok"></span>
            <em> {{ $message }}</em>
        </div>
    @endif
    @yield('content')
</div>

<!-- Scripts -->
<script src="{{ asset("/js/sweetalert.js") }}"></script>
<script src="{{ asset("/js/app.js") }}"></script>
<script src="{{ asset("/js/padlock.js") }}"></script>

{{--    <script src="//{{ Request::getHost() }}:6001/socket.io/socket.io.js"></script>--}}
@stack("scripts")
</body>
</html>
