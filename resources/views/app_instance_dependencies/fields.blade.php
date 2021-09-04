<!-- Instance Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('instance_id', 'Instance Id:') !!}
    {!! Form::select('instance_id', ['1' => '1', '2' => '2', '3' => '3'], null, ['class' => 'form-control']) !!}
</div>

<!-- Instance Dep Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('instance_dep_id', 'Instance Dep Id:') !!}
    {!! Form::select('instance_dep_id', ['1' => '1', '2' => '2', '3' => '3'], null, ['class' => 'form-control']) !!}
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    <a href="{{ route('appInstanceDependencies.index') }}" class="btn btn-secondary">Cancel</a>
</div>
