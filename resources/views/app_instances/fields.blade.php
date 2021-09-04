<!-- Application Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('application_id', 'Application Id:') !!}
    {!! Form::select('application_id', ['1' => '1', '2' => '2', '3' => '3'], null, ['class' => 'form-control']) !!}
</div>

<!-- Service Version Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('service_version_id', 'Service Version Id:') !!}
    {!! Form::select('service_version_id', ['1' => '1', '2' => '2', '3' => '3'], null, ['class' => 'form-control']) !!}
</div>

<!-- Environnement Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('environnement_id', 'Environnement Id:') !!}
    {!! Form::select('environnement_id', ['1' => '1', '2' => '2', '3' => '3'], null, ['class' => 'form-control']) !!}
</div>

<!-- Url Field -->
<div class="form-group col-sm-6">
    {!! Form::label('url', 'Url:') !!}
    {!! Form::text('url', null, ['class' => 'form-control']) !!}
</div>

<!-- Statut Field -->
<div class="form-group col-sm-12">
    {!! Form::label('statut', 'Statut:') !!}
    <label class="radio-inline">
        {!! Form::radio('statut', "0", null) !!} 0
    </label>

    <label class="radio-inline">
        {!! Form::radio('statut', "1", null) !!} 1
    </label>

</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    <a href="{{ route('appInstances.index') }}" class="btn btn-secondary">Cancel</a>
</div>
