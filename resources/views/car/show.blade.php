@extends("layouts.app")

@section("content")
  <nav class="navbar navbar-inverse">
    <ul class="nav navbar-nav">
        <li><a href="{{ URL::to('car') }}">View All Cars</a></li>
        <li><a href="{{ URL::to('car/create') }}">Create a Cars</a>
    </ul>
  </nav>

  <h1>{{$car->shortname}}</h1>
  <table class="table table-striped table-bordered">
    <thead>
        <tr>
            <td>Licence</td>
            <td>Brand</td>
            <td>Model</td>
            <td>Color</td>
            <td>Seats</td>
            <td>Comment</td>
            <td>shortname</td>
        </tr>
    </thead>
    <tbody>
    @include("partials.car.show",compact("car"))
  </tbody>
</table>
@endsection
