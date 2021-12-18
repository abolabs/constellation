@if( !isset($ignoreSourceInstance) || $ignoreSourceInstance !== true)
<!-- Instance Id Field -->
<div class="form-group col-sm-12">
    {!! Form::label('instance_id'.$modalId, \Lang::get('infra.service_instance')) !!}
    <select name="instance_id" id="instance_id{{$modalId}}" class="form-control">
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
        window.selector.make("#instance_id{{$modalId}}", "/api/service_instances", "id", ["environnement_name", "hosting_name","application_name","service_version_name","service_version","role"])
    </script>
</div>
@endif

@if( !isset($ignoreTargetInstance) || $ignoreTargetInstance !== true)
<!-- Instance Dep Id Field -->
<div class="form-group col-sm-12">
    {!! Form::label('instance_dep_id'.$modalId, \Lang::get('infra.service_dependency')) !!}
    <select name="instance_dep_id" id="instance_dep_id{{$modalId}}" class="form-control">
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
        window.selector.make("#instance_dep_id{{ $modalId }}", "/api/service_instances", "id", ["environnement_name", "hosting_name","application_name","service_version_name","service_version","role"])
    </script>
</div>
@endif

<!-- Level Field -->
<div class="form-group col-sm-12">
    {!! Form::label('level', \Lang::get('infra.dependency_level')) !!}
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
    {!! Form::label('description', \Lang::get('infra.description')) !!}
    {!! Form::textarea('description', null, ['class' => 'form-control','rows' => 3]) !!}
</div>

@if( !isset($noButton) || $noButton !== true)
<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit( \Lang::get('common.save'), ['class' => 'btn btn-primary']) !!}
    <a href="{{ route('serviceInstanceDependencies.index') }}" class="btn btn-secondary">{{ __('common.back') }}</a>
</div>
@endif
