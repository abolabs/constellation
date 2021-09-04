<!-- Service Version Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('service_version_id', 'Service Version Id:') !!}
    {!! Form::number('service_version_id', null, ['class' => 'form-control']) !!}
</div>

<!-- Service Version Dependency Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('service_version_dependency_id', 'Service Version Dependency Id:') !!}
    {!! Form::number('service_version_dependency_id', null, ['class' => 'form-control']) !!}
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    <a href="{{ route('serviceVersionDependencies.index') }}" class="btn btn-secondary">Cancel</a>
</div>
