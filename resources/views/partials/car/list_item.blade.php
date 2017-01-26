<!--
*User: Joel.DE-SOUSA
-->
<tr>
    <td>{{ $car->plate_number }}</td>
    <td>{{ $car->brand }}</td>
    <td>{{ $car->model }}</td>
    <td>{{ $car->nb_place }}</td>

    <!-- we will also add show, edit, and delete buttons -->
    <td>

        <!-- show the nerd (uses the show method found at GET /nerds/{id} -->
        <a class="btn btn-small btn-success" href="{{ route("cars.edit",$car) }}">Show this Car</a>

        <!-- delete the nerd (uses the destroy method DESTROY /nerds/{id} -->
        <form method="post" action="{{ route("cars.destroy",$car) }}"  class="pull-right">
          <input type="hidden" value="DELETE" name="_method">
          <input type="hidden" value="{{ csrf_token() }}" name="_token">
          <input disabled type="submit" id="delete" value="Delete this car" class="btn btn-warning">
        </form>
    </td>
</tr>
