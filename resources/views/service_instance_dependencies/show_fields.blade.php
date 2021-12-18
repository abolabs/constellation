<!-- Id Field -->
<div class="form-group">
    {!! Form::label('id', \Lang::get('infra.id')) !!}
    <p>{{ $serviceInstanceDependencies->id }}</p>
</div>
<hr class="my-2">

<!-- Instance Id Field -->
<div class="form-group">
    {!! Form::label('instance_id', \Lang::get('infra.service_instance')) !!}
    <p>{{ $serviceInstanceDependencies->instance_id }}</p>
</div>
<hr class="my-2">

<!-- Instance Dep Id Field -->
<div class="form-group">
    {!! Form::label('instance_dep_id', \Lang::get('infra.service_dependency')) !!}
    <p>{{ $serviceInstanceDependencies->instance_dep_id }}</p>
</div>
<hr class="my-2">

<!-- Level -->
<div class="form-group">
    {!! Form::label('level', \Lang::get('infra.dependency_level')) !!}
    <p>{{ __('service_instance_dependencies.level.'.$serviceInstanceDependencies->level) }}</p>
    <p class="font-italic">{{ __('service_instance_dependencies.level_description.'.$serviceInstanceDependencies->level) }}</p>
</div>
<hr class="my-2">

<!-- Description -->
<div class="form-group">
    {!! Form::label('description', \Lang::get('infra.description')) !!}
    <p>{{ $serviceInstanceDependencies->description }}</p>
</div>
<hr class="my-2">

<!-- Created At Field -->
<div class="form-group">
    {!! Form::label('created_at', \Lang::get('common.field_created_at')) !!}
    <p>{{ $serviceInstanceDependencies->created_at }}</p>
</div>
<hr class="my-2">

<!-- Updated At Field -->
<div class="form-group">
    {!! Form::label('updated_at', \Lang::get('common.field_updated_at')) !!}
    <p>{{ $serviceInstanceDependencies->updated_at }}</p>
</div>

