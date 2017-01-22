<tr>
    <td>{{ $user->firstname }}</td>
    <td>{{ $user->lastname }}</td>
    <td>{{ $user->phone_number }}</td>
    <td>{{ $user->stat }}</td>
    <!-- we will also add show, edit, and delete buttons -->
    <td>
        <!-- show the nerd (uses the show method found at GET /nerds/{id} -->
        <a class="btn btn-small btn-success" href="{{ URL::to('user/' . $user->id) }}">Show this User</a>
    </td>
</tr>
