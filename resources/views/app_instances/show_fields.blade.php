<!-- Id Field -->
<div class="form-group">
    {!! Form::label('id', 'Id:') !!}
    <p>{{ $appInstance->id }}</p>
</div>

<!-- Application Id Field -->
<div class="form-group">
    {!! Form::label('application_id', 'Application Id:') !!}
    <p>{{ $appInstance->application_id }}</p>
</div>

<!-- Service Version Id Field -->
<div class="form-group">
    {!! Form::label('service_version_id', 'Service Version Id:') !!}
    <p>{{ $appInstance->service_version_id }}</p>
</div>

<!-- Environnement Id Field -->
<div class="form-group">
    {!! Form::label('environnement_id', 'Environnement Id:') !!}
    <p>{{ $appInstance->environnement_id }}</p>
</div>

<!-- Url Field -->
<div class="form-group">
    {!! Form::label('url', 'Url:') !!}
    <p>{{ $appInstance->url }}</p>
</div>

<!-- Statut Field -->
<div class="form-group">
    {!! Form::label('statut', 'Statut:') !!}
    <p>{{ $appInstance->statut }}</p>
</div>

<!-- Created At Field -->
<div class="form-group">
    {!! Form::label('created_at', 'Created At:') !!}
    <p>{{ $appInstance->created_at }}</p>
</div>

<!-- Updated At Field -->
<div class="form-group">
    {!! Form::label('updated_at', 'Updated At:') !!}
    <p>{{ $appInstance->updated_at }}</p>
</div>

