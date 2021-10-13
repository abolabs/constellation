<!-- Id Field -->
<div class="form-group">
    {!! Form::label('id', 'Id') !!}
    <p>{{ $serviceVersionDependencies->id }}</p>
</div>
<hr class="my-2">

<!-- Service Version Id Field -->
<div class="form-group">
    {!! Form::label('service_version_id', 'Service Version Id') !!}
    <p>{{ $serviceVersionDependencies->service_version_id }}</p>
</div>
<hr class="my-2">

<!-- Service Version Dependency Id Field -->
<div class="form-group">
    {!! Form::label('service_version_dependency_id', 'Service Version Dependency Id') !!}
    <p>{{ $serviceVersionDependencies->service_version_dependency_id }}</p>
</div>
<hr class="my-2">

<!-- Created At Field -->
<div class="form-group">
    {!! Form::label('created_at', 'Created At') !!}
    <p>{{ $serviceVersionDependencies->created_at }}</p>
</div>
<hr class="my-2">

<!-- Updated At Field -->
<div class="form-group">
    {!! Form::label('updated_at', 'Updated At') !!}
    <p>{{ $serviceVersionDependencies->updated_at }}</p>
</div>

