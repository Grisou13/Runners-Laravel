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
        <!-- we will add this later since its a little more complicated than the other two buttons -->

        <!-- show the nerd (uses the show method found at GET /nerds/{id} -->
        <a class="btn btn-small btn-success" href="{{ URL::to('car/' . $car->id) }}">Show this Car</a>

        <!-- edit this nerd (uses the edit method found at GET /nerds/{id}/edit -->
        <a class="btn btn-small btn-info" href="{{ URL::to('car/' . $car->id . '/edit') }}">Edit this Car</a>

    </td>
</tr>
