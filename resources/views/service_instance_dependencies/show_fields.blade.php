<!-- Id Field -->
<div class="form-group">
    {!! Form::label('id', 'Id') !!}
    <p>{{ $serviceInstanceDependencies->id }}</p>
</div>
<hr class="my-2">

<!-- Instance Id Field -->
<div class="form-group">
    {!! Form::label('instance_id', 'Instance Id') !!}
    <p>{{ $serviceInstanceDependencies->instance_id }}</p>
</div>
<hr class="my-2">

<!-- Instance Dep Id Field -->
<div class="form-group">
    {!! Form::label('instance_dep_id', 'Instance Dep Id') !!}
    <p>{{ $serviceInstanceDependencies->instance_dep_id }}</p>
</div>
<hr class="my-2">

<!-- Level -->
<div class="form-group">
    {!! Form::label('level', 'Level') !!}
    <p>{{ __('service_instance_dependencies.level.'.$serviceInstanceDependencies->level) }}</p>
    <p class="font-italic">{{ __('service_instance_dependencies.level_description.'.$serviceInstanceDependencies->level) }}</p>
</div>
<hr class="my-2">

<!-- Description -->
<div class="form-group">
    {!! Form::label('description', 'Description') !!}
    <p>{{ $serviceInstanceDependencies->description }}</p>
</div>
<hr class="my-2">

<!-- Created At Field -->
<div class="form-group">
    {!! Form::label('created_at', 'Created At') !!}
    <p>{{ $serviceInstanceDependencies->created_at }}</p>
</div>
<hr class="my-2">

<!-- Updated At Field -->
<div class="form-group">
    {!! Form::label('updated_at', 'Updated At') !!}
    <p>{{ $serviceInstanceDependencies->updated_at }}</p>
</div>

