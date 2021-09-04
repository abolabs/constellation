<!-- Id Field -->
<div class="form-group">
    {!! Form::label('id', 'Id:') !!}
    <p>{{ $appInstanceDependencies->id }}</p>
</div>

<!-- Instance Id Field -->
<div class="form-group">
    {!! Form::label('instance_id', 'Instance Id:') !!}
    <p>{{ $appInstanceDependencies->instance_id }}</p>
</div>

<!-- Instance Dep Id Field -->
<div class="form-group">
    {!! Form::label('instance_dep_id', 'Instance Dep Id:') !!}
    <p>{{ $appInstanceDependencies->instance_dep_id }}</p>
</div>

<!-- Created At Field -->
<div class="form-group">
    {!! Form::label('created_at', 'Created At:') !!}
    <p>{{ $appInstanceDependencies->created_at }}</p>
</div>

<!-- Updated At Field -->
<div class="form-group">
    {!! Form::label('updated_at', 'Updated At:') !!}
    <p>{{ $appInstanceDependencies->updated_at }}</p>
</div>

