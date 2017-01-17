<tr>
    <td>{{ $car->id }}</td>
    <td>{{ $car->license_plates }}</td>
    <td>{{ $car->brand }}</td>
    <td>{{ $car->model }}</td>
    <td>{{ $car->color }}</td>
    <td>{{ $car->seats }}</td>
    <td>{{ $car->comment }}</td>
    <td>{{ $car->shortname }}</td>

    <!-- we will also add show, edit, and delete buttons -->
    <td>

        <!-- delete the nerd (uses the destroy method DESTROY /nerds/{id} -->
        <form method="post" action="car/{{ $car->id }}"  class="pull-right">
          <input type="hidden" value="DELETE" name="_method">
          <input type="hidden" value="{{ csrf_token() }}" name="_token">
          <input type="submit" value="Delete this car" class="btn btn-warning">
        </form>

        <!-- show the nerd (uses the show method found at GET /nerds/{id} -->
        <a class="btn btn-small btn-success" href="{{ URL::to('car/' . $car->id) }}">Show this Car</a>

        <!-- edit this nerd (uses the edit method found at GET /nerds/{id}/edit -->
        <a class="btn btn-small btn-info" href="{{ URL::to('car/' . $car->id . '/edit') }}">Edit this Car</a>

    </td>
</tr>
