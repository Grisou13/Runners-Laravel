@extends("layouts.app")

@section("content")

    @foreach($groups as $group)
        <table border="1" align="left" class="table-group">
            <tr>
                <th>{{$group->label}}</th>
            </tr>

            <!-- display the users in the group -->
            @foreach($group->users()->get() as $user)

                <tr>
                    <td>{{$user->first_name}}  {{$user->last_name}}</td>
                </tr>
            @endforeach

        </table>
    @endforeach

@endsection