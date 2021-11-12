<!-- Id Field -->
<div class="form-group col-lg-3">
    {!! Form::label('id', 'Id') !!}
    <p>{{ $appInstance->id }}</p>
</div>


<!-- Application Field -->
<div class="form-group col-lg-3">
    {!! Form::label('application', 'Application') !!}
    <p><a href="/applications/{{ $appInstance->application_id }}">{{ $appInstance->application->name }}</a></p>
</div>


<!-- Service Version Field -->
<div class="form-group col-lg-3">
    {!! Form::label('service_version_id', 'Service Version') !!}
    <p><a href="/services/{{ $appInstance->serviceVersion->service->id }}">{{ $appInstance->serviceVersion->service->name }} <span class="badge badge-pill badge-secondary">version {{ $appInstance->serviceVersion->version }}</span></a></p>
</div>


<!-- Environnement Id Field -->
<div class="form-group col-lg-3">
    {!! Form::label('environnement_id', 'Environnement') !!}
    <p><a href="/environnements/{{ $appInstance->environnement_id }}">{{ $appInstance->environnement->name }}</a></p>
</div>

<!-- Hosting Id Field -->
<div class="form-group col-lg-3">
    {!! Form::label('hosting_id', 'Hosting') !!}
    <p><a href="/hostings/{{ $appInstance->hosting_id }}">{{ $appInstance->hosting->name }}</a></p>
</div>


<!-- Url Field -->
<div class="form-group col-lg-3">
    {!! Form::label('url', 'Url') !!}
    <p><a href="{{ $appInstance->url }}">{{ $appInstance->url }}</a></p>
</div>


<!-- Statut Field -->
<div class="form-group col-lg-3">
    {!! Form::label('statut', 'Statut') !!}
    <p>
        <label class="switch switch-label switch-success">
            <input type="checkbox" class="switch-input" disabled @if ( $appInstance->statut ); checked @endif>
            <span class="switch-slider" data-checked="On" data-unchecked="Off"></span>
        </label>
    </p>
</div>

<!-- Created At Field -->
<div class="form-group col-lg-3">
    {!! Form::label('created_at', 'Created At') !!}
    <p>{{ $appInstance->created_at }}</p>
</div>


<!-- Updated At Field -->
<div class="form-group col-lg-3">
    {!! Form::label('updated_at', 'Updated At') !!}
    <p>{{ $appInstance->updated_at }}</p>
</div>
