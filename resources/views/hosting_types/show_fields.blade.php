<!-- Id Field -->
<div class="form-group">
    {!! Form::label('id', \Lang::get('hosting_type.id')) !!}
    <p>{{ $hostingType->id }}</p>
</div>
<hr class="my-2">

<!-- Name Field -->
<div class="form-group">
    {!! Form::label('name', \Lang::get('hosting_type.name')) !!}
    <p>{{ $hostingType->name }}</p>
</div>
<hr class="my-2">

<!-- Description Field -->
<div class="form-group">
    {!! Form::label('description', \Lang::get('hosting_type.description')) !!}
    <p>{{ $hostingType->description }}</p>
</div>
<hr class="my-2">

<!-- Created At Field -->
<div class="form-group">
    {!! Form::label('created_at', \Lang::get('hosting_type.created_at')) !!}
    <p>{{ $hostingType->created_at }}</p>
</div>
<hr class="my-2">

<!-- Updated At Field -->
<div class="form-group">
    {!! Form::label('updated_at', \Lang::get('hosting_type.created_at')) !!}
    <p>{{ $hostingType->updated_at }}</p>
</div>

