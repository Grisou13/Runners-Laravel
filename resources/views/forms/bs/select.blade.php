<div class="form-group{{ $errors->has($name) ? ' has-error' : '' }}">
  {{ Form::label($name, ucfirst($name), array('class' => 'col-md-4 control-label')) }}
  <div class="col-md-6">
    {{ Form::select($name,$values,old($name,$value), array_merge(['class' => 'form-control',"disabled"], $attributes)) }}
    @if ($errors->has($name))
        <span class="help-block">
            <strong>{{ $errors->first($name) }}</strong>
        </span>
    @endif
  </div>
</div>
