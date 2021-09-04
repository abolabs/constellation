<!-- Id Field -->
<div class="form-group">
    {!! Form::label('id', 'Id:') !!}
    <p>{{ $hosting->id }}</p>
</div>

<!-- Name Field -->
<div class="form-group">
    {!! Form::label('name', 'Name:') !!}
    <p>{{ $hosting->name }}</p>
</div>

<!-- Hosting Type Id Field -->
<div class="form-group">
    {!! Form::label('hosting_type_id', 'Hosting Type Id:') !!}
    <p>{{ $hosting->hosting_type_id }}</p>
</div>

<!-- Localisation Field -->
<div class="form-group">
    {!! Form::label('localisation', 'Localisation:') !!}
    <p>{{ $hosting->localisation }}</p>
</div>

<!-- Created At Field -->
<div class="form-group">
    {!! Form::label('created_at', 'Created At:') !!}
    <p>{{ $hosting->created_at }}</p>
</div>

<!-- Updated At Field -->
<div class="form-group">
    {!! Form::label('updated_at', 'Updated At:') !!}
    <p>{{ $hosting->updated_at }}</p>
</div>

