<!-- Id Field -->
<div class="form-group col-lg-3">
    {!! Form::label('id', \Lang::get('infra.id')) !!}
    <p>{{ $serviceInstance->id }}</p>
</div>

<!-- Service Version Field -->
<div class="form-group col-lg-3">
    {!! Form::label('service_version_id', \Lang::get('infra.service')) !!}
    <p><a href="/services/{{ $serviceInstance->serviceVersion->service->id }}">{{ $serviceInstance->serviceVersion->service->name }} <span class="badge badge-pill badge-secondary">version {{ $serviceInstance->serviceVersion->version }}</span></a></p>
</div>


<!-- Environnement Id Field -->
<div class="form-group col-lg-3">
    {!! Form::label('environnement_id', \Lang::get('infra.environnement')) !!}
    <p><a href="/environnements/{{ $serviceInstance->environnement_id }}">{{ $serviceInstance->environnement->name }}</a></p>
</div>

<!-- Hosting Id Field -->
<div class="form-group col-lg-3">
    {!! Form::label('hosting_id', \Lang::get('hosting.hosting_type')) !!}
    <p><a href="/hostings/{{ $serviceInstance->hosting_id }}">{{ $serviceInstance->hosting->name }}</a></p>
</div>


<!-- Url Field -->
<div class="form-group col-lg-3">
    {!! Form::label('url', \Lang::get('infra.url')) !!}
    <p>
    @if (!empty($serviceInstance->url))
        <a href="{{ $serviceInstance->url }}" target="_blank" rel="noopener">{{ $serviceInstance->url }} <i class="cil-external-link"></i></a>
    @else
        <span class="font-italic"> n/a </span>
    @endif
    </p>
</div>

<!-- Role Field -->
<div class="form-group col-lg-3">
    {!! Form::label('role', \Lang::get('infra.role')) !!}
    <p>{{ $serviceInstance->role }}
</div>


<!-- Statut Field -->
<div class="form-group col-lg-3">
    {!! Form::label('statut', \Lang::get('infra.status')) !!}
    <p>
        <label class="switch switch-label switch-success">
            <input type="checkbox" class="switch-input" disabled @if ( $serviceInstance->statut ); checked @endif>
            <span class="switch-slider" data-checked="On" data-unchecked="Off"></span>
        </label>
    </p>
</div>

<!-- Created At Field -->
<div class="form-group col-lg-3">
    {!! Form::label('created_at', \Lang::get('common.field_created_at')) !!}
    <p>{{ $serviceInstance->created_at }}</p>
</div>


<!-- Updated At Field -->
<div class="form-group col-lg-3">
    {!! Form::label('updated_at', \Lang::get('common.field_updated_at')) !!}
    <p>{{ $serviceInstance->updated_at }}</p>
</div>
