@extends("layouts.app")

@section("content")

    @foreach($groups as $group)
        <div id="container-{{$group->id}}" class="panel panel-default col-md-2">
            <div class="panel-heading">{{$group->label}}</div>
            <!-- display the users in the group -->
            @foreach($group->users()->get() as $user)
                <div id="{{$user->id}}" class="panel-body">
                    {{$user->first_name}}  {{$user->last_name}}
                </div>
            @endforeach
        </div>
    @endforeach
@endsection
