 {{ Form::bsText("name",$run->name) }}
 {{ Form::bsText("nb_passenger",$run->nb_passenger) }}

 <div class="form-group">
     <label for="planned_at" class="col-md-4 control-label">Planifé à</label>
     <div class="col-md-6">
         <input type="hidden" id="input_planned_at" name="planned_at" value="">
         <div id="planned_at"></div>
     </div>
 </div>
 @php
     $waypoints = $waypoints->mapWithKeys(function($p){
         return [(string)$p->id => $p->name];
     });
     $car_types = $car_types->mapWithKeys(function($c){
         return [(string)$c->id => $c->name];
     });
     $cars = $cars->mapWithKeys(function($c){
             return [(string)$c->id => $c->name];
     });
     $users = $users->mapWithKeys(function($c){
             return [(string)$c->id => $c->name];
     });
 @endphp
<div id="waypoint-selection" class="waypoints">
    @if(!$run->exists)
        <div id="waypoint-first">
            <div class="form-group{{ $errors->has("waypoints") ? ' has-error' : '' }}">
                <div class="col-md-4">
                    {{ Form::label("Itinéraire", ucfirst("waypoint"), array('class' => 'control-label')) }}
                    @if ($errors->has("waypoint"))
                        <span class="help-block">
                        <strong>{{ $errors->first("waypoints") }}</strong>
                    </span>
                    @endif
                </div>


                <div class="col-md-6">
                    {{ Form::select("waypoints[]",$waypoints,null, ['class' => 'form-control']) }}
                </div>
            </div>
            {{--{!! Form::bsSelect("waypoints[]", $waypoints) !!}--}}
            <div class="form-group">
                <div class="col-md-push-4 col-md-6">
                    <button style="width:100%" class="btn btn-info" id="add-waypoint" data-points="{{ $waypoints }}">
                        <span class="glyphicon glyphicon-plus"></span>
                    </button>
                </div>
            </div>
        </div>
        <div id="waypoint-last">
            <div class="form-group{{ $errors->has("waypoints") ? ' has-error' : '' }}">
                <div class="col-md-6 col-md-push-4">
                    {{ Form::select("waypoints[]",$waypoints,null, ['class' => 'form-control']) }}
                </div>
            </div>
        </div>

    @else
        @foreach($run->waypoints as $point)
            @if($loop->first)
                <div id="waypoint-first">
                    <div class="form-group{{ $errors->has("waypoint") ? ' has-error' : '' }}">
                        {{ Form::label("waypoints", "Itinéraire", array('class' => 'col-md-4 control-label')) }}
                        <div class="col-md-6">
                            {{ Form::select("waypoints[]",$waypoints,old("waypoints[".$point->id."]", $point->id), ['class' => 'form-control']) }}
                        </div>
                    </div>
                    {{--{!! Form::bsSelect("waypoints[]", $waypoints) !!}--}}
                    <div class="form-group">
                        <div class="col-md-push-4 col-md-6">
                            <button type="button" style="width:50%;margin-left:auto;margin-right:auto;" class="btn btn-info" id="add-waypoint" data-points="{{ $waypoints }}">
                                <span class="glyphicon glyphicon-plus"></span>
                            </button>
                        </div>
                    </div>
                </div>
            @elseif($loop->last)
                <div id="waypoint-last">
                    <div class="form-group{{ $errors->has("waypoints") ? ' has-error' : '' }}">
                        <div class="col-md-6 col-md-push-4">
                            {{ Form::select("waypoints[]",$waypoints,old("waypoints[".$point->id."]", $point->id), ['class' => 'form-control']) }}
                        </div>
                    </div>
                </div>
            @else
                <div class="form-group button-remove {{ $errors->has("waypoints") ? 'has-error' : '' }}">
                    <div class="col-md-5 col-md-push-4">
                        {{ Form::select("waypoints[]",$waypoints,old("waypoints[".$point->id."]",$point->id), ['class' => 'form-control']) }}
                    </div>
                    <div class="col-md-1 col-md-push-4">
                        <button class="btn btn-danger" type="button">
                            <span class="glyphicon glyphicon-minus"></span>
                        </button>
                    </div>
                </div>
            @endif
        @endforeach
    @endif
</div>




<div id="subs">
    <div class="form-group {{ $errors->has("subscriptions") ? ' has-error' : '' }}">
        <div class="">
            {{ Form::label("subscriptions", ucfirst("Convois"), array('class' => 'control-label col-md-4')) }}
            @if ($errors->has("subscriptions"))
                <span class="help-block">
                        <strong>{{ $errors->first("subscriptions") }}</strong>
                    </span>
            @endif
        </div>
        <div class="col-md-6">
            <button style="width:100%" class="btn btn-info" id="add-sub">
                <span class="glyphicon glyphicon-plus"></span>
            </button>
        </div>
    </div>
    @if($run->exists)
        @foreach($run->subscriptions as $sub)
            <div class="col-md-push-4 col-md-5">
                {{ dump($sub) }}
                <div class="row">
                    @if($sub->car_type_id != null)
                        {!! Form::select("subscriptions[{$sub->id}][car_type]",$car_types, old("subscriptions[{$sub->id}][car_type]",$sub->car_type_id), ["placeholder"=>" ",'class' => 'col-md-2']) !!}
                        {!! Form::select("subscriptions[{$sub->id}][car]",$cars, old("subscriptions[{$sub->id}][car]",$sub->car_id), ["placeholder"=>" ",'class' => 'col-md-2']) !!}
                    @else
                        {!! Form::select("subscriptions[{$sub->id}][car_type]",$car_types, old("subscriptions[{$sub->id}][car_type]",$sub->car_type_id), ["placeholder"=>" ",'class' => 'col-md-2']) !!}
                    @endif

                    {!! Form::select("subscriptions[{$sub->id}][user]",$users, old("subscriptions[{$sub->id}][user]",$sub->user_id), ["placeholder"=>" ",'class' => 'col-md-2']) !!}
                    <div class="col-md-2">
                        <button class="btn btn-danger" type="button">
                            <span class="glyphicon glyphicon-minus"></span>
                        </button>
                    </div>
                </div>

            </div>

{{--first a user must select a car type to get list of all cars--}}
{{--any user may be assigned to a run--}}
{{--a minus button is available to delete the subscription--}}
        @endforeach
    @endif
</div>


 @push("styles")
 <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
 <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-ui-timepicker-addon/1.6.3/jquery-ui-timepicker-addon.min.css">
 @endpush

@push("scripts")
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-ui-timepicker-addon/1.6.3/jquery-ui-timepicker-addon.min.js"></script>
 <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-ui-timepicker-addon/1.6.3/i18n/jquery-ui-timepicker-fr.js"></script>
<script type="text/javascript">

// picker pour la date des runs
$( function() {
  $( "#planned_at" ).datetimepicker({
      altField: "#input_planned_at",
      timeFormat:"hh:mm",
      dateFormat: 'yy-mm-dd',
      altFieldTimeOnly: false
  });
} );
// _______________________________
    document.querySelectorAll(".button-remove").forEach(function(container){
        var b = container.getElementsByTagName("button")[0]
        b.addEventListener("click",function(e){
            e.preventDefault()
            container.parentNode.removeChild(container)
        })
    })
    var add = document.getElementById("add-waypoint")
    add.addEventListener("click",function(e){
        e.preventDefault()
        var waypoints = JSON.parse(add.dataset.points)
        console.log(waypoints)
        var select = document.createElement("select")
        select.name = "waypoints[]"
        select.classList.add("form-control")
        for(var p in waypoints)
        {
            console.log(p)
            var opt = document.createElement('option');
            var id = p//Object.keys(p)[0]
            opt.value= id
            opt.innerHTML = waypoints[p]
            select.appendChild(opt)
        }
        var last = document.getElementById("waypoint-last")
        var container = document.createElement("div")
        container.classList.add("form-group")
        var subContainer = document.createElement("div")
        subContainer.classList.add("col-md-5")
        subContainer.classList.add("col-md-push-4")
        subContainer.appendChild(select)

        var btn = document.createElement("button")
        btn.classList.add("btn")
        btn.classList.add("btn-danger")
        btn.type="button"

        var icon = document.createElement("span")
        icon.classList.add("glyphicon")
        icon.classList.add("glyphicon-minus")
        btn.appendChild(icon)

        btn.addEventListener("click",function(e){
            e.preventDefault();
            document.getElementById("waypoint-selection").removeChild(container)
        })
        var btnContainer = document.createElement("div")
        btnContainer.classList.add("col-md-1")
        btnContainer.classList.add("col-md-push-4")
        btnContainer.appendChild(btn)
        container.appendChild(subContainer)
        container.appendChild(btnContainer)
        document.getElementById("waypoint-selection").insertBefore(container,document.getElementById("waypoint-last"))
    })


    /*
window.api.get("/waypoints")
 .then(function(res){
     var points = window.waypoint_cache = res.data;
     var first = document.createElement("select")
     first.id = "waypoint-first"
     first.name = "waypoints[]"
     var last = document.createElement("select")
     last.id="waypoint-last"
     last.name = "waypoints[]"
     points.forEach(function(p){
         var opt = document.createElement('option');
         opt.value=p.id
         opt.innerHTML = p.name
         first.appendChild(opt)
         last.appendChild(opt)
     })
     var btn = document.createElement("button")
     btn.classList.add("btn")
     btn.classList.add("btn-default")

     var icon = document.createElement("span")
     icon.classList.add("glyphicon")
     icon.classList.add("glyphicon-plus")
     btn.appendChild(icon)
     btn.addEventListener("click",function(e){
         e.preventDefault()
         var select = document.createElement("select")
         select.name = "waypoints[]"
         window.waypoint_cache.forEach(function(p){
             console.log(p)
             var opt = document.createElement('option');
             opt.value=p.id
             opt.innerHTML = p.name
             select.appendChild(opt)
         })
         last.parentNode.insertBefore(select,last)
     })
     var waypoints_container = document.getElementById("waypoint-selection")
     waypoints_container.appendChild(first)
     waypoints_container.appendChild(last)
     waypoints_container.appendChild(btn)

 })

window.api.get("/car_types?status=free")
 .then(function(res){
     var types = window.car_types = res.data;
     var type = document.createElement("select")
     type.id="car_type_selector"
     type.name = "car_type"
     types.forEach(function(p){
         var opt = document.createElement('option');
         opt.value=p.id
         opt.innerHTML = p.type
         type.appendChild(opt)
     })
     document.getElementById("car_type").appendChild(type)

 })
 */
</script>
@endpush

@push("scripts")
<script type="text/javascript">
 $(document).ready(function(){
     $("input:disabled,select:disabled").removeAttr("disabled");
 });
</script>
@endpush
