 {{ Form::bsText("title",$run->title) }}
 {{ Form::bsText("nb_passenger",$run->nb_passenger) }}
 {{ Form::bsText("planned_at",$run->nb_passenger) }}


<div id="waypoint-selection" class="waypoints">
    @php
        $waypoints = $waypoints->map(function($p){
            return [(string)$p->id => $p->name];
        });
    @endphp
    @if(!$run->exists)
        <div id="waypoint-first">
            {!! Form::bsSelect("waypoints[]", $waypoints) !!}
        </div>
        <div id="waypoint-last">
            {!! Form::bsSelect("waypoints[]",$waypoints) !!}
        </div>

    @else
        @foreach($run->waypoints as $point)
            @if($loop->first)
                <div id="waypoint-first">
                    {!! Form::bsSelect("waypoints[]",$waypoints, $point ) !!}
                </div>
            @elseif($loop->last)
                <div id="waypoint-last">
                    {!! Form::bsSelect("waypoints[]",$waypoints, $point ) !!}
                </div>
            @else
                {!! Form::bsSelect("waypoints[]",$waypoints, $point ) !!}
            @endif
        @endforeach
    @endif
</div>

 <button class="btn btn-default" id="add-waypoint" data-points="{{ $waypoints }}">
     <span class="glyphicon glyphicon-plus"></span>
 </button>

@if($run->exists)
<div id="car_type">
    {!! Form::bsSelect("car_type",$car_types) !!}
</div>
@endif

@push("scripts")
<script>
    var add = document.getElementById("add-waypoint")
    add.addEventListener("click",function(e){
        e.preventDefault()
        var waypoints = JSON.parse(add.dataset.points)
        console.log(waypoints)
        var select = document.createElement("select")
        select.name = "waypoints[]"
        waypoints.forEach(function(p){
            console.log(p)
            var opt = document.createElement('option');
            var id = Object.keys(p)[0]
            opt.value= id
            opt.innerHTML = p[id]
            select.appendChild(opt)
        })
        var last = document.getElementById("waypoint-last")
        document.getElementById("waypoint-selection").insertBefore(select,document.getElementById("waypoint-last"))
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