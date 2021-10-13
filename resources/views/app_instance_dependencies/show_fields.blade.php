<!-- Id Field -->
<div class="form-group">
    {!! Form::label('id', 'Id') !!}
    <p>{{ $appInstanceDependencies->id }}</p>
</div>
<hr class="my-2">

<!-- Instance Id Field -->
<div class="form-group">
    {!! Form::label('instance_id', 'Instance Id') !!}
    <p>{{ $appInstanceDependencies->instance_id }}</p>
</div>
<hr class="my-2">

<!-- Instance Dep Id Field -->
<div class="form-group">
    {!! Form::label('instance_dep_id', 'Instance Dep Id') !!}
    <p>{{ $appInstanceDependencies->instance_dep_id }}</p>
</div>
<hr class="my-2">

<!-- Created At Field -->
<div class="form-group">
    {!! Form::label('created_at', 'Created At') !!}
    <p>{{ $appInstanceDependencies->created_at }}</p>
</div>
<hr class="my-2">

<!-- Updated At Field -->
<div class="form-group">
    {!! Form::label('updated_at', 'Updated At') !!}
    <p>{{ $appInstanceDependencies->updated_at }}</p>
</div>

