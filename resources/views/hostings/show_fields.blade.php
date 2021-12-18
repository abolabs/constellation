<!-- Id Field -->
<div class="form-group col-lg-3">
    {!! Form::label('id', \Lang::get('hosting.id')) !!}
    <p>{{ $hosting->id }}</p>
</div>

<!-- Hosting Type Id Field -->
<div class="form-group col-lg-3">
    {!! Form::label('hosting_type', \Lang::get('hosting.name')) !!}
    <p>{{ $hosting->hostingType->name }}</p>
</div>

<!-- Localisation Field -->
<div class="form-group col-lg-3">
    {!! Form::label('localisation', \Lang::get('hosting.localisation')) !!}
    <p>{{ $hosting->localisation }}</p>
</div>

<!-- Created At Field -->
<div class="form-group col-lg-3">
    {!! Form::label('created_at', \Lang::get('common.field_created_at')) !!}
    <p>{{ $hosting->created_at }}</p>
</div>

<!-- Updated At Field -->
<div class="form-group col-lg-3">
    {!! Form::label('updated_at', \Lang::get('common.field_updated_at')) !!}
    <p>{{ $hosting->updated_at }}</p>
</div>

