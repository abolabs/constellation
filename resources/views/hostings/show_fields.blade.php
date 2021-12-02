<!-- Id Field -->
<div class="form-group col-lg-3">
    {!! Form::label('id', 'Id') !!}
    <p>{{ $hosting->id }}</p>
</div>

<!-- Hosting Type Id Field -->
<div class="form-group col-lg-3">
    {!! Form::label('hosting_type', 'Hosting Type') !!}
    <p>{{ $hosting->hostingType->name }}</p>
</div>

<!-- Localisation Field -->
<div class="form-group col-lg-3">
    {!! Form::label('localisation', 'Localisation') !!}
    <p>{{ $hosting->localisation }}</p>
</div>

<!-- Created At Field -->
<div class="form-group col-lg-3">
    {!! Form::label('created_at', 'Created At') !!}
    <p>{{ $hosting->created_at }}</p>
</div>

<!-- Updated At Field -->
<div class="form-group col-lg-3">
    {!! Form::label('updated_at', 'Updated At') !!}
    <p>{{ $hosting->updated_at }}</p>
</div>

