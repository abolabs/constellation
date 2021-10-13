<!-- Id Field -->
<div class="form-group">
    {!! Form::label('id', 'Id') !!}
    <p>{{ $appInstance->id }}</p>
</div>
<hr class="my-2">

<!-- Application Id Field -->
<div class="form-group">
    {!! Form::label('application_id', 'Application Id') !!}
    <p>{{ $appInstance->application_id }}</p>
</div>
<hr class="my-2">

<!-- Service Version Id Field -->
<div class="form-group">
    {!! Form::label('service_version_id', 'Service Version Id') !!}
    <p>{{ $appInstance->service_version_id }}</p>
</div>
<hr class="my-2">

<!-- Environnement Id Field -->
<div class="form-group">
    {!! Form::label('environnement_id', 'Environnement Id') !!}
    <p>{{ $appInstance->environnement_id }}</p>
</div>
<hr class="my-2">

<!-- Url Field -->
<div class="form-group">
    {!! Form::label('url', 'Url') !!}
    <p>{{ $appInstance->url }}</p>
</div>
<hr class="my-2">

<!-- Statut Field -->
<div class="form-group">
    {!! Form::label('statut', 'Statut') !!}
    <p>{{ $appInstance->statut }}</p>
</div>
<hr class="my-2">

<!-- Created At Field -->
<div class="form-group">
    {!! Form::label('created_at', 'Created At') !!}
    <p>{{ $appInstance->created_at }}</p>
</div>
<hr class="my-2">

<!-- Updated At Field -->
<div class="form-group">
    {!! Form::label('updated_at', 'Updated At') !!}
    <p>{{ $appInstance->updated_at }}</p>
</div>
