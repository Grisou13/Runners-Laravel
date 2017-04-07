 {{ Form::bsText("name",$run->name) }}
 {{ Form::bsText("nb_passenger",$run->nb_passenger) }}
 {{ Form::bsText("planned_at",$run->planned_at) }}


<div id="waypoint-selection" class="waypoints">
    @php
        $waypoints = $waypoints->mapWithKeys(function($p){
            return [(string)$p->id => $p->name];
        });
        $car_types = $car_types->mapWithKeys(function($c){
            return [(string)$c->id => $c->name];
        });
    @endphp

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



@if(!$run->exists)
<div id="car_type">
    {!! Form::bsSelect("car_type",$car_types) !!}
</div>
@endif

@push("scripts")
<script>
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