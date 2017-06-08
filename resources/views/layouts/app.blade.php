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
    <link rel="stylesheet" href="{{ asset("/css/comment.css") }}">
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
            timeout: 10000,
            contentType:"application/json",
            headers: {'X-Access-Token': window.Laravel.token}
        });
    </script>
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-default navbar-static-top" >
            <div class="container">
                <div class="navbar-header">

                    <!-- Collapsed Hamburger -->
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
                        <span class="sr-only">Toggle Navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>

                    <!-- Branding Image -->
                    <a class="navbar-brand" href="{{ url('/') }}">
                        <span>{{ config('app.name', 'Laravel') }}</span>
                        @if(config("app.debug"))
                            <small>- {{ app_version() }}</small>
                        @endif
                    </a>
                </div>

                <div class="collapse navbar-collapse" id="app-navbar-collapse">
                    <!-- Left Side Of Navbar -->
                    <ul class="nav navbar-nav">
                        @if (!Auth::guest())
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                Courses <span class="caret"></span>
                            </a>
                            <ul class="dropdown-menu">
                                <li><a href="{{ route("runs.index") }}">Liste courses</a></li>
                                <li><a href="{{ route("runs.create") }}">Créer course</a></li>
                            </ul>
                        </li>
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                Voitures <span class="caret"></span>
                            </a>
                            <ul class="dropdown-menu">
                                <li><a href="{{ route("cars.index") }}">liste voitures</a></li>
                                <li><a href="{{ route("cars.create") }}">Créer voiture</a></li>
                            </ul>
                        </li>
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                    Chauffeurs <span class="caret"></span>
                                </a>
                                <ul class="dropdown-menu">
                                    <li><a href="{{ route("users.index") }}">liste chauffeurs</a></li>
                                    <li><a href="{{ route("users.create") }}">Créer chauffeur</a></li>
                                </ul>
                            </li>
                        <li>
                            <a href="{{ route("groups.index") }}">Groupes</a>
                        </li>
                        <li>
                            <a href="{{ route("schedule.index") }}">Horaires</a>
                        </li>
                        @endif
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="nav navbar-nav navbar-right">
                        <!-- Authentication Links -->
                        @if (Auth::guest())
                            <li><a href="{{ url('/login') }}">Login</a></li>
                            <li><a href="{{ url('/register') }}">Register</a></li>
                        @else

                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>
            
                                <ul class="dropdown-menu" role="menu">
                                    <li>
                                        <a href="{{ url('/logout') }}"
                                            onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                            Logout
                                        </a>

                                        <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
                                            {{ csrf_field() }}
                                        </form>
                                    </li>
                                    <li><a href="{{ route("users.edit",["user"=>auth()->user()]) }}">profile</a></li>
                                </ul>
                            </li>
                        @endif
                    </ul>
                </div>
            </div>
        </nav>
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
    <script src="{{ asset("/js/display-comments.js") }}"></script>
    {{--<script src="{{ asset("/js/html2canvas.js") }}"></script>--}}
    {{--<script src="{{ asset("/js/jspdf.min.js")}}" ></script>--}}
    {{--<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/2.3.2/jspdf.plugin.autotable.js"></script>--}}
{{--    <script src="//{{ Request::getHost() }}:6001/socket.io/socket.io.js"></script>--}}
    {{--<script src="{{ asset("/js/padlock.js") }}"></script>--}}
    @stack("scripts")
</body>
</html>
