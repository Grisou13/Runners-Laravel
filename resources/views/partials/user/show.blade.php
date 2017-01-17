<tr>
    <td>{{ $user->first_name }}</td>
    <td>{{ $user->last_name }}</td>
    <td>{{ $user->shortname }}</td>
    <td>{{ $user->email }}</td>
    <td>{{ $user->phone }}</td>
    <td>{{ $user->sex == 0 ? "Female" : "Male"}}</td>

    <!-- we will also add show, edit, and delete buttons -->
    <td>

        <!-- delete the nerd (uses the destroy method DESTROY /nerds/{id} -->
        <form method="post" action="user/{{ $user->id }}"  class="pull-right">
          <input type="hidden" value="DELETE" name="_method">
          <input type="hidden" value="{{ csrf_token() }}" name="_token">
          <input type="submit" value="Delete this user" class="btn btn-warning">
        </form>

        <!-- show the nerd (uses the show method found at GET /nerds/{id} -->
        <a class="btn btn-small btn-success" href="{{ URL::to('user/' . $user->id) }}">Show this User</a>

        <!-- edit this nerd (uses the edit method found at GET /nerds/{id}/edit -->
        <a class="btn btn-small btn-info" href="{{ URL::to('user/' . $user->id . '/edit') }}">Edit this User</a>

    </td>
</tr>
