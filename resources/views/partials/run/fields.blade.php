 {{ Form::bsText("name",$run->name) }}
 {{ Form::bsText("nb_passenger",$run->nb_passenger) }}
 <script>
     window.resource_cache = <?php echo json_encode([
         "waypoints"=>$waypoints,
         "car_types"=>$car_types,
         "cars"=>$cars,
         "users"=>$users,
         "subscriptions"=> $run->exists ? $run->subscriptions : false
     ]) ?>
 </script>
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




<div id="subs-container">
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
            <button style="width:100%" class="btn btn-info" id="add-sub" type="button">
                <span class="glyphicon glyphicon-plus"></span>
            </button>
        </div>
    </div>
    <div id="subs" class="subs" >

    </div>
    {{--@if($run->exists)--}}
        {{--@foreach($run->subscriptions as $sub)--}}
            {{--<div class="col-md-push-4 col-md-5">--}}
                {{--{{ dump($sub) }}--}}
                {{--<div class="row">--}}
                    {{--@if($sub->car_type_id != null)--}}
                        {{--{!! Form::select("subscriptions[{$sub->id}][car_type]",$car_types, old("subscriptions[{$sub->id}][car_type]",$sub->car_type_id), ["placeholder"=>" ",'class' => 'col-md-2']) !!}--}}
                        {{--{!! Form::select("subscriptions[{$sub->id}][car]",$cars, old("subscriptions[{$sub->id}][car]",$sub->car_id), ["placeholder"=>" ",'class' => 'col-md-2']) !!}--}}
                    {{--@else--}}
                        {{--{!! Form::select("subscriptions[{$sub->id}][car_type]",$car_types, old("subscriptions[{$sub->id}][car_type]",$sub->car_type_id), ["placeholder"=>" ",'class' => 'col-md-2']) !!}--}}
                    {{--@endif--}}

                    {{--{!! Form::select("subscriptions[{$sub->id}][user]",$users, old("subscriptions[{$sub->id}][user]",$sub->user_id), ["placeholder"=>" ",'class' => 'col-md-2']) !!}--}}
                    {{--<div class="col-md-2">--}}
                        {{--<button class="btn btn-danger" type="button">--}}
                            {{--<span class="glyphicon glyphicon-minus"></span>--}}
                        {{--</button>--}}
                    {{--</div>--}}
                {{--</div>--}}

            {{--</div>--}}

{{--first a user must select a car type to get list of all cars--}}
{{--any user may be assigned to a run--}}
{{--a minus button is available to delete the subscription--}}
        {{--@endforeach--}}
    {{--@endif--}}
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


const generateSubscription = (sub) => {
    var cars = window.resource_cache.cars
    var car_types = window.resource_cache.car_types
    var runners = window.resource_cache.users

    var container = document.createElement("div")
    var hasCarType = sub.car_type ? true:false
    var hasCar = sub.car ? true:false
    var hasRunner = sub.user ? true:false

    var car = sub.car
    var user = sub.user
    var ctype = sub.car_type

    var cars_input = document.createElement("select")
    var runners_input = document.createElement("select")
    var car_types_input = document.createElement("select")

    var emptyOption = document.createElement("option")
    emptyOption.value=-1
    emptyOption.text=" "

    var delete_btn = document.createElement("button")
    delete_btn.innerHTML="<span class='glyphicon glyphicon-remove'></span>"
    delete_btn.type = "button"
    delete_btn.addEventListener("click",(e)=>{
        e.preventDefault()
        container.parentNode.removeChild(container)
    })
    var reset_btn = document.createElement("button")
    reset_btn.innerHTML="<span class='glyphicon glyphicon-repeat'></span>"
    reset_btn.type = "button"
    reset_btn.addEventListener("click", (e)=>{
        e.preventDefault()
        cars_input.innerHTML = ""
        cars_input.add(emptyOption)
        cars_input.value = -1
        car_types_input.value = -1
        runners_input.value = -1



        car_types_input.classList.add("col-md-5")
        car_types_input.classList.add("col-md-push-4")
        cars_input.classList.add("hidden")
        runners_input.classList.add("hidden")
        reset_btn.classList.add("hidden")
        delete_btn.classList.add("hidden")
        //TODO show only car_type input
    })
    //SET INVISBLE
    car_types_input.classList.remove("col-md-1")
    cars_input.classList.remove("col-md-1")
    runners_input.classList.remove("col-md-1")
    reset_btn.classList.remove("col-md-push-4")
    reset_btn.classList.remove("col-md-1")
    delete_btn.classList.remove("col-md-1")

    car_types_input.classList.add("col-md-5")
    car_types_input.classList.add("col-md-push-4")
    cars_input.classList.add("hidden")
    runners_input.classList.add("hidden")
    delete_btn.classList.add("hidden")
    reset_btn.classList.add("hidden")

    car_types_input.classList.add("form-control")
    cars_input.classList.add("form-control")
    runners_input.classList.add("form-control")
    delete_btn.classList.add("btn")
    delete_btn.classList.add("btn-danger")

    cars_input.add(emptyOption.cloneNode())
    car_types_input.add(emptyOption.cloneNode())
    runners_input.add(emptyOption.cloneNode())
    car_types.map((ct)=>{
        var option = document.createElement("option")
        option.text = ct.name
        option.value = ct.id
        car_types_input.add(option)
    })
    runners.map((u)=>{
        var option = document.createElement("option")
        option.text = u.name
        option.value = u.id
        runners_input.add(option)
    })
    if(hasCarType){
        car_types_input.value = ctype.id
        cars_input.innerHTML = ""
        cars_input.add(emptyOption)
        cars.filter( c => c.car_type_id == ctype.id).forEach( (c) => {
            var option = document.createElement("option")
            option.text = c.name
            option.value = c.id
            cars_input.add(option)
        })
    }
    if(hasRunner)
        runners_input.value = user.id
    if(hasCar)
        cars_input.value = car.id

    cars_input.name="subscriptions[][car]"
    runners_input.name = "subscriptions[][user]"
    car_types_input.name = "subscriptions[][car_type]"

    if(hasCarType){
        //set the other inputs visible
        cars_input.classList.toggle("hidden")
        runners_input.classList.toggle("hidden")
        delete_btn.classList.toggle("hidden")
        reset_btn.classList.toggle("hidden")
        car_types_input.classList.remove("col-md-5")
        car_types_input.classList.remove("col-md-push-4")
        delete_btn.classList.add("col-md-1")
        reset_btn.classList.add("col-md-1")
        reset_btn.classList.add("col-md-push-4")
        car_types_input.classList.add("col-md-1")
        cars_input.classList.add("col-md-1")
        runners_input.classList.add("col-md-1")
    }
    else{
        //set only car_type input to visible
        car_types_input.classList.remove("col-md-1")
        cars_input.classList.remove("col-md-1")
        runners_input.classList.remove("col-md-1")
        reset_btn.classList.remove("col-md-push-4")
        reset_btn.classList.remove("col-md-1")
        delete_btn.classList.remove("col-md-1")

        car_types_input.classList.add("col-md-5")
        car_types_input.classList.add("col-md-push-4")
        cars_input.classList.add("hidden")
        runners_input.classList.add("hidden")
        delete_btn.classList.add("hidden")
        reset_btn.classList.add("hidden")
    }

    car_types_input.addEventListener("change",(e) => {
        var type = e.target.value && e.target.value != -1 ? e.target.value : false
        if(type != -1){

            cars_input.innerHTML = "" //reset the cars
            cars_input.add(emptyOption)
            console.log(cars)
            cars.filter( c => c.car_type_id == type).forEach( (c) => {
                var option = document.createElement("option")
                option.text = c.name
                option.value = c.id
                cars_input.add(option)
            })
        //SET VISIBLE
        cars_input.classList.toggle("hidden")
        runners_input.classList.toggle("hidden")
        delete_btn.classList.toggle("hidden")
        reset_btn.classList.toggle("hidden")
        car_types_input.classList.remove("col-md-5")
        car_types_input.classList.remove("col-md-push-4")
        delete_btn.classList.add("col-md-1")
        reset_btn.classList.add("col-md-1")
        reset_btn.classList.add("col-md-push-4")
        car_types_input.classList.add("col-md-1")
        cars_input.classList.add("col-md-1")
        runners_input.classList.add("col-md-1")

        //TODO set other inputs to show
        }
        else{
            //we can't do anything if there is a user
            if(runners_input.value == -1){
                cars_input.value = -1
                //reset the car_type input to full size
                //set other inputs hidden
            }
        }
    })
    runners_input.addEventListener("change", (e)=>{
        var user = e.target.value && e.target.value != -1 ? e.target.value : false
        if(user){
            return false
        }
        else{
            if(car_types_input.value == -1){
                cars_input.value = -1
                //reset car_type input to full size
                car_types_input.classList.remove("col-md-1")
                cars_input.classList.remove("col-md-1")
                runners_input.classList.remove("col-md-1")
                reset_btn.classList.remove("col-md-push-4")
                reset_btn.classList.remove("col-md-1")
                delete_btn.classList.remove("col-md-1")

                car_types_input.classList.add("col-md-5")
                car_types_input.classList.add("col-md-push-4")
                cars_input.classList.add("hidden")
                runners_input.classList.add("hidden")
                delete_btn.classList.add("hidden")
                reset_btn.classList.add("hidden")
                //TODO set only car_type to show
            }
        }
    })
    container.appendChild(reset_btn)
    container.appendChild(delete_btn)
    container.appendChild(car_types_input)
    container.appendChild(cars_input)
    container.appendChild(runners_input)
    return container

}
var subs = document.querySelector("#subs")
var add_sub = document.querySelector("#add-sub")
add_sub.addEventListener("click",(e)=>{
    e.preventDefault()
    subs.appendChild(generateSubscription({car_type:null,car:null,user:null}))
})
var data = window.resource_cache.subscriptions ? window.resource_cache.subscriptions : []
data.forEach((s)=> subs.appendChild(generateSubscription(s)))

</script>
@endpush

@push("scripts")
<script type="text/javascript">
 $(document).ready(function(){
     $("input:disabled,select:disabled").removeAttr("disabled");
 });
</script>
@endpush
