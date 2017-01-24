@extends("layouts.app")

@section("content")
<nav class="navbar navbar-inverse">
    <ul class="nav navbar-nav">
        <li><a href="{{ URL::to('car') }}">View All Cars</a></li>
    </ul>
    <button type="button" class="btn btn-success pull-right" id="padlock" onclick="enable()">
      Closed padlock
    </button>
</nav>
@include("partials.car.edit",["mode"=>"edit","car"=>$car])
@endsection
