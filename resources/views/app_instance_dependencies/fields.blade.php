<!-- Instance Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('instance_id', 'Instance Id:') !!}
    <select name="instance_id" id="instance_id" class="form-control">
    @if (isset($appInstanceDependencies->appInstance->id))
        <option value="{{$appInstanceDependencies->appInstance->id}}">[{{$appInstanceDependencies->appInstance->id}}] {{$appInstanceDependencies->appInstance->service_version_name}}</option>
    @endif
    </select>
    <script>
        window.selector.make("#instance_id", "/api/app_instances", "id", "service_version_name")
    </script>
</div>

<!-- Instance Dep Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('instance_dep_id', 'Instance Dep Id:') !!}
    <select name="instance_dep_id" id="instance_dep_id" class="form-control">
    @if (isset($appInstanceDependencies->appInstanceDep->id))
        <option value="{{$appInstanceDependencies->appInstanceDep->id}}">[{{$appInstanceDependencies->appInstanceDep->id}}] {{$appInstanceDependencies->appInstanceDep->service_version_name}}</option>
    @endif
    </select>
    <script>
        window.selector.make("#instance_dep_id", "/api/app_instances", "id", "service_version_name")
    </script>
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    <a href="{{ route('appInstanceDependencies.index') }}" class="btn btn-secondary">Cancel</a>
</div>
