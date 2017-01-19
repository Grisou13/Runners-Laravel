@extends("layouts.app")

@section("content")
  <nav class="navbar navbar-inverse">
    <ul class="nav navbar-nav">
        <li><a href="{{ URL::to('car') }}">View All Cars</a></li>
    </ul>
    <!--
    <form method="post" action="edit_mod" class="pull-right">
      <input type="hidden" value="{{ csrf_token() }}" name="_token">
      <input type="hidden" name="edit_mod" value="true">
      <input type="submit" value="Access to Edit mod" class="btn btn-success">
    </form>
    -->
  </nav>
    @include("partials.car.show",array(compact("car"), $delete = "show"))
@endsection
