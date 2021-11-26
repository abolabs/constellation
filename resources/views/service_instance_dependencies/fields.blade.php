@if( !isset($ignoreSourceInstance) || $ignoreSourceInstance !== true)
<!-- Instance Id Field -->
<div class="form-group col-sm-12">
    {!! Form::label('instance_id', 'Instance Id:') !!}
    <select name="instance_id" id="instance_id" class="form-control">
    @if (isset($serviceInstanceDependencies->serviceInstance->id))
        <option value="{{$serviceInstanceDependencies->serviceInstance->id}}">[{{$serviceInstanceDependencies->serviceInstance->id}}] {{$serviceInstanceDependencies->serviceInstance->service_version_name}}</option>
    @endif
    </select>
    <script>
        window.selector.make("#instance_id", "/api/service_instances", "id", ["environnement_name", "hosting_name","application_name","service_version_name","service_version","role"])
    </script>
</div>
@endif

@if( !isset($ignoreTargetInstance) || $ignoreTargetInstance !== true)
<!-- Instance Dep Id Field -->
<div class="form-group col-sm-12">
    {!! Form::label('instance_dep_id', 'Instance Dep Id:') !!}
    <select name="instance_dep_id" id="instance_dep_id" class="form-control">
    @if (isset($serviceInstanceDependencies->serviceInstanceDep->id))
        <option value="{{$serviceInstanceDependencies->serviceInstanceDep->id}}">[{{$serviceInstanceDependencies->serviceInstanceDep->id}}] {{$serviceInstanceDependencies->serviceInstanceDep->service_version_name}}</option>
    @endif
    </select>
    <script>
        window.selector.make("#instance_dep_id", "/api/service_instances", "id", ["environnement_name", "hosting_name","application_name","service_version_name","service_version","role"])
    </script>
</div>
@endif

@if( !isset($noButton) || $noButton !== true)
<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    <a href="{{ route('serviceInstanceDependencies.index') }}" class="btn btn-secondary">Cancel</a>
</div>
@endif
