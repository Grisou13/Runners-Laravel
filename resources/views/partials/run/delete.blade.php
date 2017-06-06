
{!! Form::model($run,["route"=>["runs.destroy",$run],'class' => 'form-horizontal', 'method' => 'destroy']) !!}

{!! Form::token() !!}

<button class="btn btn-danger" type="submit" id="delete-run">
    <span class="glyphicon glyphicon-trash"></span>&nbsp;<span>Delete</span>
</button>
<script>
    document.getElementById("delete-run").addEventListener("click",(e)=>{
        e.preventDefault();
        swal({
            title: "Are you sure?",
            text: "The run will be deleted! (you can still ask the admins to recover it",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Yes, delete it!",
            closeOnConfirm: false
        },
        function(){
            console.log(e.target.parentNode.submit())
//            swal("Deleted!", "Your imaginary file has been deleted.", "success");
        });
    })
</script>

{!! Form::close() !!}
