<tr>
    <td>{{ $car->license_plates }}</td>
    <td>{{ $car->brand }}</td>
    <td>{{ $car->model }}</td>
    <td>{{ $car->seats }}</td>

    <!-- we will also add show, edit, and delete buttons -->
    <td>

        <!-- show the nerd (uses the show method found at GET /nerds/{id} -->
        <a class="btn btn-small btn-success" href="{{ URL::to('car/' . $car->id) . '/edit' }}">Show this Car</a>

        <!-- delete the nerd (uses the destroy method DESTROY /nerds/{id} -->
        <form method="post" action="{{ route("car.destroy",$car) }}"  class="pull-right">
          <input type="hidden" value="DELETE" name="_method">
          <input type="hidden" value="{{ csrf_token() }}" name="_token">
          <input disabled type="submit" id="delete" value="Delete this car" class="btn btn-warning">
        </form>
    </td>
</tr>
