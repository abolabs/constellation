<!-- Id Field -->
<div class="form-group">
    {!! Form::label('id', 'Id') !!}
    <p>{{ $hosting->id }}</p>
</div>
<hr class="my-2">

<!-- Name Field -->
<div class="form-group">
    {!! Form::label('name', 'Name') !!}
    <p>{{ $hosting->name }}</p>
</div>
<hr class="my-2">

<!-- Hosting Type Id Field -->
<div class="form-group">
    {!! Form::label('hosting_type_id', 'Hosting Type Id') !!}
    <p>{{ $hosting->hosting_type_id }}</p>
</div>
<hr class="my-2">

<!-- Localisation Field -->
<div class="form-group">
    {!! Form::label('localisation', 'Localisation') !!}
    <p>{{ $hosting->localisation }}</p>
</div>
<hr class="my-2">

<!-- Created At Field -->
<div class="form-group">
    {!! Form::label('created_at', 'Created At') !!}
    <p>{{ $hosting->created_at }}</p>
</div>
<hr class="my-2">

<!-- Updated At Field -->
<div class="form-group">
    {!! Form::label('updated_at', 'Updated At') !!}
    <p>{{ $hosting->updated_at }}</p>
</div>

