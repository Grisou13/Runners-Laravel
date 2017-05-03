<tr class="run" id="{{$run->id}}">
    <td class="status {{ $run->status }}"></td>
    <!-- Run name and people -->
    <td class="col-md-2 text-center">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="title">
                        {{ $run->name }}
                    </div>
                    <div class="passengers">
                        {{ $run->nb_passenger }} personnes
                    </div>
                </div>
            </div>
        </div>


    </td>
    <!-- Waypoint details -->
    <td colspan="6">
        @foreach($run->waypoints as $point)
            {{ $point->name }}
            @if(!$loop->last)
                <span class='glyphicon glyphicon-arrow-right'></span>
            @endif
        @endforeach
    </td>
    <td>
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-6">
                    <div class="btn-group-vertical" role="group" aria-label="">
                        <button class="btn btn-info searchable" name="button" data-searchable="car_types"><span class="glyphicon glyphicon-plus-sign"></span>Type</button>
                        <button class="btn btn-info searchable" name="button" data-searchable="cars"><span class="glyphicon glyphicon-plus-sign"></span>Voiture</button>
                    </div>
                </div>
                <div class="col-md-6">
                    <button class="btn btn-info searchable" name="button" data-searchable="users">
                        <span class="glyphicon glyphicon-plus-sign"></span>
                        <span>Utilisateur</span>
                    </button>
                </div>
            </div>

            @forelse($run->subscriptions as $sub)
                @if($sub->status=="ready_to_go")
                    <div class="row bg-success">
                        <div class="col-md-6">
                            <button class="btn btn-danger">
                                <span class="glyphicon glyphicon-remove-sign"></span>
                                {{ $sub->car->name }}
                            </button>
                        </div>
                        <div class="col-md-6">
                            <button class="btn btn-danger">
                                <span class="glyphicon glyphicon-remove-sign"></span>
                                {{ $sub->user->name }}
                            </button>
                        </div>
                    </div>
                @elseif($sub->status == "missing_car")
                    <div class="row bg-warning">
                        <div class="col-md-6">
                            <div class="btn-group-vertical" role="group" aria-label="">
                                @if($sub->car_type_id != null)
                                    <button class="btn btn-info searchable" name="button" data-searchable="cars" data-restrict="car_type={{$sub->car_type->id}}&status=free">
                                        <span class="glyphicon glyphicon-plus-sign"></span>
                                        Voiture
                                    </button>
                                    <button class="btn btn-danger">
                                        <span class="glyphicon glyphicon-remove-sign"></span>
                                        {{ $sub->car_type->name }}
                                    </button>
                                @else
                                    <button class="btn btn-info searchable" name="button" data-searchable="car_types">
                                        <span class="glyphicon glyphicon-plus-sign"></span>
                                        Type
                                    </button>
                                    <button class="btn btn-info searchable" name="button" data-searchable="cars">
                                        <span class="glyphicon glyphicon-plus-sign"></span>
                                        Voiture
                                    </button>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-6">
                            <button class="btn btn-danger ">
                                <span class="glyphicon glyphicon-remove-sign"></span>
                                {{ $sub->user->name }}
                            </button>
                        </div>
                    </div>
                @elseif($sub->status == "missing_user")
                    <div class="row bg-warning">
                        <div class="col-md-6">
                            <div class="btn-group-vertical" role="group" aria-label="">
                                @if($sub->car != null)
                                    <button class="btn btn-danger">
                                        <span class="glyphicon glyphicon-remove-sign"></span>
                                        {{ $sub->car->name }}
                                    </button>
                                @elseif($sub->car_type != null)
                                    <button class="btn btn-info searchable" name="button" data-searchable="cars" data-restrict="car_type={{$sub->car_type}}&status=free">
                                        <span class="glyphicon glyphicon-plus-sign"></span>
                                        Voiture
                                    </button>
                                    <button class="btn btn-danger">
                                        <span class="glyphicon glyphicon-remove-sign"></span>
                                        {{ $sub->car_type->name }}
                                    </button>
                                @else
                                    <button class="btn btn-info searchable" name="button" data-searchable="car_types">
                                        <span class="glyphicon glyphicon-plus-sign"></span>
                                        Type
                                    </button>
                                    <button class="btn btn-info searchable" name="button" data-searchable="cars">
                                        <span class="glyphicon glyphicon-plus-sign"></span>
                                        Voiture
                                    </button>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-6">
                            <button class="btn btn-info searchable" name="button" data-searchable="users">
                                <span class="glyphicon glyphicon-plus-sign"></span>
                                Utilisateur
                            </button>
                        </div>
                    </div>
                @endif
            @empty

            @endforelse
        </div>
    </td>
</tr>
<script type="text/javascript">
  alert('bonjour');
</script>
