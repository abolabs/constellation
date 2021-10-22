<!-- Id Field -->
<div class="form-group">
    {!! Form::label('id', 'Id') !!}
    <p>{{ $appInstance->id }}</p>
</div>
<hr class="my-2">

<!-- Application Field -->
<div class="form-group">
    {!! Form::label('application', 'Application') !!}
    <p><a href="/applications/{{ $appInstance->application_id }}">{{ $appInstance->application->name }}</a></p>
</div>
<hr class="my-2">

<!-- Service Version Field -->
<div class="form-group">
    {!! Form::label('service_version_id', 'Service Version') !!}
    <p><a href="/services/{{ $appInstance->serviceVersion->service->id }}">{{ $appInstance->serviceVersion->service->name }} <span class="badge badge-pill badge-secondary">version {{ $appInstance->serviceVersion->version }}</span></a></p>
</div>
<hr class="my-2">

<!-- Environnement Id Field -->
<div class="form-group">
    {!! Form::label('environnement_id', 'Environnement') !!}
    <p><a href="/environnements/{{ $appInstance->environnement_id }}">{{ $appInstance->environnement->name }}</a></p>
</div>
<hr class="my-2">

<!-- Url Field -->
<div class="form-group">
    {!! Form::label('url', 'Url') !!}
    <p><a href="{{ $appInstance->url }}">{{ $appInstance->url }}</a></p>
</div>
<hr class="my-2">

<!-- Statut Field -->
<div class="form-group">
    {!! Form::label('statut', 'Statut') !!}
    <p>
        <label class="switch switch-label switch-success">
            <input type="checkbox" class="switch-input" disabled @if ( $appInstance->statut ); checked @endif>
            <span class="switch-slider" data-checked="On" data-unchecked="Off"></span>
        </label>
    </p>
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
