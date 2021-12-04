@if( !isset($ignoreSourceInstance) || $ignoreSourceInstance !== true)
<!-- Instance Id Field -->
<div class="form-group col-sm-12">
    {!! Form::label('instance_id', 'Instance Id:') !!}
    <select name="instance_id" id="instance_id" class="form-control">
    @if (isset($serviceInstanceDependencies->serviceInstance->id))
        <option value="{{$serviceInstanceDependencies->serviceInstance->id}}">
            [{{$serviceInstanceDependencies->serviceInstance->id}}]
            {{$serviceInstanceDependencies->serviceInstance->environnement->name}} /
            {{$serviceInstanceDependencies->serviceInstance->hosting->name}} /
            {{$serviceInstanceDependencies->serviceInstance->application->name}} /
            {{$serviceInstanceDependencies->serviceInstance->serviceVersion->service->name}} /
            {{$serviceInstanceDependencies->serviceInstance->serviceVersion->version}} /
            {{$serviceInstanceDependencies->serviceInstance->role}}
        </option>
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
        <option value="{{$serviceInstanceDependencies->serviceInstanceDep->id}}">
            [{{$serviceInstanceDependencies->serviceInstanceDep->id}}]
            {{$serviceInstanceDependencies->serviceInstanceDep->environnement->name}} /
            {{$serviceInstanceDependencies->serviceInstanceDep->hosting->name}} /
            {{$serviceInstanceDependencies->serviceInstanceDep->application->name}} /
            {{$serviceInstanceDependencies->serviceInstanceDep->serviceVersion->service->name}} /
            {{$serviceInstanceDependencies->serviceInstanceDep->serviceVersion->version}} /
            {{$serviceInstanceDependencies->serviceInstanceDep->role}}
        </option>
    @endif
    </select>
    <script>
        window.selector.make("#instance_dep_id", "/api/service_instances", "id", ["environnement_name", "hosting_name","application_name","service_version_name","service_version","role"])
    </script>
</div>
@endif

<!-- Level Field -->
<div class="form-group col-sm-12">
    {!! Form::label('level', 'Level') !!}
        @foreach ( \App\Models\ServiceInstanceDependencies::$levelsList as $level)
        <div class="form-check">
            <input class="form-check-input" type="radio" name="level" id="level{{$level}}" value="{{ $level }}" @if (isset($serviceInstanceDependencies->serviceInstanceDep->id) && $level == $serviceInstanceDependencies->level ) checked="checked" @endif>
            <label class="form-check-label" for="level{{$level}}">
                [{{ __('service_instance_dependencies.level.'.$level) }}]
            </label>
            <p class="font-italic text-muted">{{ __('service_instance_dependencies.level_description.'.$level) }}</p>
        </div>
        @endforeach
</div>

<!-- Description Field -->
<div class="form-group col-sm-6">
    {!! Form::label('description', 'Description') !!}
    {!! Form::textarea('description', null, ['class' => 'form-control','rows' => 3]) !!}
</div>

@if( !isset($noButton) || $noButton !== true)
<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    <a href="{{ route('serviceInstanceDependencies.index') }}" class="btn btn-secondary">Cancel</a>
</div>
@endif
