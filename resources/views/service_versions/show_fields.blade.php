<!-- Id Field -->
<div class="form-group">
    {!! Form::label('id', 'Id') !!}
    <p>{{ $serviceVersion->id }}</p>
</div>
<hr class="my-2">

<!-- Service Id Field -->
<div class="form-group">
    {!! Form::label('service_id', 'Service Id') !!}
    <p>{{ $serviceVersion->service_id }}</p>
</div>
<hr class="my-2">

<!-- Version Field -->
<div class="form-group">
    {!! Form::label('version', 'Version') !!}
    <p>{{ $serviceVersion->version }}</p>
</div>
<hr class="my-2">

<!-- Created At Field -->
<div class="form-group">
    {!! Form::label('created_at', 'Created At') !!}
    <p>{{ $serviceVersion->created_at }}</p>
</div>
<hr class="my-2">

<!-- Updated At Field -->
<div class="form-group">
    {!! Form::label('updated_at', 'Updated At') !!}
    <p>{{ $serviceVersion->updated_at }}</p>
</div>

