<div class="form-group {{ $required?"required":"" }} {{ $errors->has($name) ? ' has-error' : '' }}">
  {{ Form::label($name, ucfirst($name), array('class' => 'col-md-4 control-label')) }}
  <div class="col-md-6">
    {{ Form::select($old,$values,old($old,$value), array_merge(['class' => 'form-control'], $attributes)) }}
    @if ($errors->has($name))
        <span class="help-block">
            <strong>{{ $errors->first($name) }}</strong>
        </span>
    @endif
  </div>
</div>
