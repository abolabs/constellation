<!-- Name Field -->
<div class="form-group col-sm-6">
    {!! Form::label('name', \Lang::get('hosting.name')) !!}
    {!! Form::text('name', null, ['class' => 'form-control']) !!}
</div>

<!-- Hosting Type Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('hosting_type_id', \Lang::get('hosting.hosting_type')) !!}
    <select name="hosting_type_id" id="hosting_type_id" class="form-control">
    @if (isset($hosting->hostingType->id))
        <option value="{{$hosting->hostingType->id}}">[{{$hosting->hostingType->id}}] {{$hosting->hostingType->name}}</option>
    @endif
    </select>
    <script>
        window.selector.make("#hosting_type_id", "/api/hostingTypes", "id", "name")
    </script>
</div>

<!-- Localisation Field -->
<div class="form-group col-sm-6">
    {!! Form::label('localisation', \Lang::get('hosting.localisation')) !!}
    {!! Form::text('localisation', null, ['class' => 'form-control']) !!}
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit(\Lang::get('common.save'), ['class' => 'btn btn-primary']) !!}
    <a href="{{ route('hostings.index') }}" class="btn btn-secondary">{{ __('common.back') }}</a>
</div>
