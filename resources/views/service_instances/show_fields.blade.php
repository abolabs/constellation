<!-- Id Field -->
<div class="form-group col-lg-3">
    {!! Form::label('id', 'Id') !!}
    <p>{{ $serviceInstance->id }}</p>
</div>


<!-- Application Field -->
<div class="form-group col-lg-3">
    {!! Form::label('application', 'Application') !!}
    <p><a href="/applications/{{ $serviceInstance->application_id }}">{{ $serviceInstance->application->name }}</a></p>
</div>


<!-- Service Version Field -->
<div class="form-group col-lg-3">
    {!! Form::label('service_version_id', 'Service Version') !!}
    <p><a href="/services/{{ $serviceInstance->serviceVersion->service->id }}">{{ $serviceInstance->serviceVersion->service->name }} <span class="badge badge-pill badge-secondary">version {{ $serviceInstance->serviceVersion->version }}</span></a></p>
</div>


<!-- Environnement Id Field -->
<div class="form-group col-lg-3">
    {!! Form::label('environnement_id', 'Environnement') !!}
    <p><a href="/environnements/{{ $serviceInstance->environnement_id }}">{{ $serviceInstance->environnement->name }}</a></p>
</div>

<!-- Hosting Id Field -->
<div class="form-group col-lg-3">
    {!! Form::label('hosting_id', 'Hosting') !!}
    <p><a href="/hostings/{{ $serviceInstance->hosting_id }}">{{ $serviceInstance->hosting->name }}</a></p>
</div>


<!-- Url Field -->
<div class="form-group col-lg-3">
    {!! Form::label('url', 'Url') !!}
    <p><a href="{{ $serviceInstance->url }}" target="_blank">{{ $serviceInstance->url }} <i class="cil-external-link"></i></a></p>
</div>

<!-- Role Field -->
<div class="form-group col-sm-6">
    {!! Form::label('role', 'Role') !!}
    <p>{{ $serviceInstance->role }}
</div>


<!-- Statut Field -->
<div class="form-group col-lg-3">
    {!! Form::label('statut', 'Statut') !!}
    <p>
        <label class="switch switch-label switch-success">
            <input type="checkbox" class="switch-input" disabled @if ( $serviceInstance->statut ); checked @endif>
            <span class="switch-slider" data-checked="On" data-unchecked="Off"></span>
        </label>
    </p>
</div>

<!-- Created At Field -->
<div class="form-group col-lg-3">
    {!! Form::label('created_at', 'Created At') !!}
    <p>{{ $serviceInstance->created_at }}</p>
</div>


<!-- Updated At Field -->
<div class="form-group col-lg-3">
    {!! Form::label('updated_at', 'Updated At') !!}
    <p>{{ $serviceInstance->updated_at }}</p>
</div>
