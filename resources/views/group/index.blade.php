<!-- User : Eric.BOUSBAA -->

@extends("layouts.app")
@push("styles")
<link rel="stylesheet" href="{{ asset("/css/group.css") }}">
@endpush

@push("scripts")
<script src="{{ asset("/js/dragula.min.js") }}"></script>
<script src="{{ asset("/js/groups.js") }}"></script>
@endpush
@section("content")
<div class="l">

    <!-- Display each group -->
    <div class="row " id="group-container">
        @foreach($groups as $group)

            @if($loop->iteration % 6 == 1)
    </div>
    <div class="row">
        @endif
        <div id="container-{{$group->id}}" class="panel panel-default col-md-2" style="background-color:#{{$group->color}};">
            <div class="panel-heading" style="background-color:#{{$group->color}}; opacity:0.3px !important;" >{{$group->name}}</div>
            <!-- display the users in the group -->
            {{----}}
            @foreach($group->users as $user)
                <div id="{{$user->id}}" class="panel-body">
                    {{$user->firstname}}  {{$user->lastname}}
                </div>
            @endforeach

        </div>
        @endforeach
    </div>

    <div class="row">

        <!--  Display the list for users wihtout group -->
        <div id="container-null" class="panel panel-default col-md-2">
            <div class="panel-heading">Sans groupe</div>
            @foreach($no_group as $user)
                <div id="{{$user->id}}" class="panel-body">
                    {{$user->firstname}}  {{$user->lastname}}
                </div>
            @endforeach
        </div>
        <!-- New group -->
        <button type="button" class="btn btn-default" onclick="getNewGroup()" >Créer un nouveau groupe</button>

    </div>
</div>
@endsection
