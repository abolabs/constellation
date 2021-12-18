<!-- Id Field -->
<div class="form-group">
    {!! Form::label('id', \Lang::get('infra.id')) !!}
    <p>{{ $serviceVersion->id }}</p>
</div>
<hr class="my-2">

<!-- Service Id Field -->
<div class="form-group">
    {!! Form::label('service_id', \Lang::get('infra.service')) !!}
    <p>{{ $serviceVersion->service_id }}</p>
</div>
<hr class="my-2">

<!-- Version Field -->
<div class="form-group">
    {!! Form::label('version', \Lang::get('infra.version')) !!}
    <p>{{ $serviceVersion->version }}</p>
</div>
<hr class="my-2">

<!-- Created At Field -->
<div class="form-group">
    {!! Form::label('created_at', \Lang::get('common.field_created_at')) !!}
    <p>{{ $serviceVersion->created_at }}</p>
</div>
<hr class="my-2">

<!-- Updated At Field -->
<div class="form-group">
    {!! Form::label('updated_at', \Lang::get('common.field_updated_at')) !!}
    <p>{{ $serviceVersion->updated_at }}</p>
</div>

