@extends("layouts.app")

@section("content")

    <div class="row" >
        <div class="col-md-1">
            <a href="#" class="btn btn-success pull-right" id="padlock" role="button" onclick="enable()">Closed padlock</a>
        </div>

    </div>
    <!-- Display each group -->
    <div class="row " id="group-container">
        @foreach($groups as $group)
            @if($loop->iteration % 6 == 1)
            </div>
            <div class="row">
            @endif
            <div id="container-{{$group->id}}" class="panel panel-default col-md-2 disabledbutton">
                <div class="panel-heading">{{$group->label}}</div>
                <!-- display the users in the group -->
                @foreach($group->users()->get()->where("stat","active") as $user)

                    <div id="{{$user->id}}" class="panel-body">
                        {{$user->firstname}}  {{$user->lastname}}
                    </div>
                @endforeach

            </div>
        @endforeach
    </div>


    <div class="row">
        <!--  Display the list for users wihtout group -->
        <div id="container-null" class="panel panel-default col-md-2 disabledbutton">
            <div class="panel-heading">Utilisateurs sans groupe</div>
            @foreach($no_group as $user)
                <div id="{{$user->id}}" class="panel-body">
                    {{$user->firstname}}  {{$user->lastname}}
                </div>
            @endforeach
        </div>

        <!-- New group -->
        <button type="button" class="btn btn-default" onclick="getNewGroup()">Default</button>

    </div>



@endsection
