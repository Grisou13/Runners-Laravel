@extends("layouts.app")

@section("content")

    @foreach($groups as $group)
        <div class="panel panel-default col-sm-1">
            <div class="panel-heading">
                <h3 class="panel-title">{{$group->label}}</h3>
            </div>
            @foreach($group->users()->get() as $user)
                <div class="panel-body">
                    {{$user->first_name}}  {{$user->last_name}}
                </div>

                {{--<tr id="table-user">--}}
                    {{--<td >{{$user->first_name}}  {{$user->last_name}}</td>--}}
                {{--</tr>--}}
            @endforeach

        </div>

        {{--<table border="1" align="left" class="table-group">--}}
            {{--<tr>--}}
                {{--<th></th>--}}
            {{--</tr>--}}

            {{--<!-- display the users in the group -->--}}


        {{--</table>--}}
    @endforeach

@endsection