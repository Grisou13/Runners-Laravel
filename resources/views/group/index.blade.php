@extends("layouts.app")

@section("content")
    <!-- Display each group -->
    @foreach($groups as $group)
        <div id="container-{{$group->id}}" class="panel panel-default col-md-2">
            <div class="panel-heading">{{$group->label}}</div>
            <!-- display the users in the group -->
            @foreach($group->users()->get()->where("stat", "==", "active") as $user)

                <div id="{{$user->id}}" class="panel-body">
                    {{$user->firstname}}  {{$user->lastname}}
                </div>
            @endforeach

        </div>
    @endforeach

    <!--  Display the list for users wihtout group -->

    <!-- <div id="container-null" class="panel panel-default col-md-2">
        <div class="panel-heading">Utilisateurs sans groupe</div>
        @foreach($no_group as $user)
            <div id="{{$user->id}}" class="panel-body">
                {{$user->firstname}}  {{$user->lastname}}
            </div>
        @endforeach
    </div> -->
@endsection
