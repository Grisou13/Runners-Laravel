<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>
</head>
<body>
    <style >
{{--        {!! include(public_path("/css/print.css")) !!}--}}
    </style>
    <style type="text/css">
        .tg  {border-collapse:collapse;border-spacing:0;}
        .tg td{font-family:Arial, sans-serif;font-size:14px;padding:10px 5px;border-style:solid;border-width:1px;overflow:hidden;word-break:normal;}
        .tg th{font-family:Arial, sans-serif;font-size:14px;font-weight:normal;padding:10px 5px;border-style:solid;border-width:1px;overflow:hidden;word-break:normal;}
        .tg .tg-baqh{text-align:center;vertical-align:top}
        .tg .tg-yw4l{vertical-align:top;text-align: left;}

        .run-table tr:last-of-type
        {
            border-bottom: 1px solid black;
        }
        .run-table tr:first-of-type
        {
            border-top: 1px solid black;
        }
        /*.vertical-text {*/
            /*transform: rotate(-90deg);*/
            /*transform-origin: 50% 50%;*/
            /*float: left;*/
        /*}*/
        .title{
            max-width: 30px;
            -ms-word-wrap:break-word;
            word-wrap:break-word;
        }
        .waypoints{
            max-width: 900px;
        }
        .waypoints ul{
            display: inline-block;
            list-style-type: none;
        }
        .waypoints li{
            list-style: none;
            list-style-type: none;
            display: inline-block;
        }
        .tg-wrap{
            display:block;
            width: 100%;
            padding-top: 2px;
            padding-bottom: 2px;
            margin-top: 10px;
        }
        .run-table{
            width: 100%;
            table-layout: fixed;
            border-collapse: collapse;
            border-spacing:0;
        }
        .run-table td{
            border-style: solid; border-width:1px;
            overflow:hidden;
        }
        #app{
            width: 98%;
            height: 98%;
            min-height: 200px;
            font-size:  30pt;
            margin-bottom: 10px;
            padding: 20px;
        }
        html, body{
            /*display: inline-block;*/
            margin: 0px auto;
            text-align: center;
            width: 99vw;
            height:100vh;
        }
        thead:before, thead:after { display: none; }
        tbody:before, tbody:after { display: none; }
    </style>
{{--    <link href="{{ asset("/css/print.css") }}" rel="stylesheet">--}}
    @stack("styles")


    <div id="app">
        @yield('content')
    </div>

    @stack("scripts")
</body>
</html>
