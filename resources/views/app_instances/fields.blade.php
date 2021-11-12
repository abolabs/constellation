@if (!isset($ignoreApp) || $ignoreApp !== true)
<!-- Application Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('application_id', 'Application ') !!}
    <select name="application_id" id="application_id" class="form-control">
    @if (isset($appInstance->application->id))
        <option value="{{$appInstance->application->id}}">[{{$appInstance->application->id}}] {{$appInstance->application->name}}</option>
    @endif
    </select>
    <script>
        window.selector.make("#application_id", "/api/applications", "id", "name")
    </script>
</div>
@endif

<!-- Service Version Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('service_id', 'Service ') !!}
    <select name="service_id" id="service_id" class="form-control">
    @if (isset($appInstance->serviceVersion->service->id))
        <option value="{{$appInstance->serviceVersion->service->id}}">[{{$appInstance->serviceVersion->service->id}}] {{$appInstance->serviceVersion->service->name}}</option>
    @endif
    </select>
    <script>
        window.selector.make("#service_id", "/api/services", "id", ["name"])
    </script>
</div>

<!-- Service Version Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('service_version_id', 'Service Version ') !!}
    <select name="service_version_id" id="service_version_id" class="form-control">
    @if (isset($appInstance->serviceVersion->id))
        <option value="{{$appInstance->serviceVersion->id}}">[{{$appInstance->serviceVersion->id}}] {{$appInstance->serviceVersion->version}}</option>
    @endif
    </select>
    <script>
        initServiceVersionSelector();
        function initServiceVersionSelector()
        {
            window.selector.make("#service_version_id", "/api/serviceVersions", "id", ["version"], {
                service_id: $('#service_id').val()
            })
        }
        $('#service_id').change((e) => {
            console.log("service updated ",  $('#service_id').val());
            $('#service_version_id').val("");
            initServiceVersionSelector();
        });
    </script>
</div>

<!-- Environnement Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('environnement_id', 'Environnement ') !!}
    <select name="environnement_id" id="environnement_id" class="form-control">
    @if (isset($appInstance->environnement->id))
        <option value="{{$appInstance->environnement->id}}">[{{$appInstance->environnement->id}}] {{$appInstance->environnement->name}}</option>
    @endif
    </select>
    <script>
        window.selector.make("#environnement_id", "/api/environnements", "id", "name")
    </script>
</div>

<!-- Hosting Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('hosting_id', 'Hosting ') !!}
    <select name="hosting_id" id="hosting_id" class="form-control">
    @if (isset($appInstance->hosting->id))
        <option value="{{$appInstance->hosting->id}}">[{{$appInstance->hosting->id}}] {{$appInstance->hosting->name}}</option>
    @endif
    </select>
    <script>
        window.selector.make("#hosting_id", "/api/hostings", "id", "name")
    </script>
</div>

<!-- Url Field -->
<div class="form-group col-sm-6">
    {!! Form::label('url', 'Url') !!}
    {!! Form::text('url', null, ['class' => 'form-control']) !!}
</div>

<!-- Statut Field -->
<div class="form-group col-sm-12">
    {!! Form::label('statut', 'Statut') !!}
    <p>
        <label class="switch switch-label switch-success">
            <input type="checkbox" class="switch-input" name="statut" value="1" @if ( isset($appInstance->application->id) && $appInstance->statut ); checked @endif>
            <span class="switch-slider" data-checked="On" data-unchecked="Off"></span>
        </label>
    </p>
</div>

@if (!isset($noButton) || $noButton !== true)
<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    <a href="{{ route('appInstances.index') }}" class="btn btn-secondary">Cancel</a>
</div>
@endif
