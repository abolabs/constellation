<!-- Service Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('service_id', \Lang::get('infra.service')) !!}
    <select name="service_id" id="service_id" class="form-control">
    @if (isset($serviceVersion->service->id))
        <option value="{{$serviceVersion->service->id}}">[{{$serviceVersion->service->id}}] {{$serviceVersion->service->name}}</option>
    @endif
    </select>
    <script>
        window.selector.make("#service_id", "/api/services", "id", "name")
    </script>
</div>

<!-- Version Field -->
<div class="form-group col-sm-6">
    {!! Form::label('version', \Lang::get('infra.version')) !!}
    {!! Form::text('version', null, ['class' => 'form-control']) !!}
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit(\Lang::get('common.save'), ['class' => 'btn btn-primary']) !!}
    <a href="{{ route('serviceVersions.index') }}" class="btn btn-secondary">{{ __('common.back') }}</a>
</div>
