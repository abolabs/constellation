<!-- Id Field -->
<div class="form-group">
    {!! Form::label('id', 'Id') !!}
    <p>{{ $hostingType->id }}</p>
</div>
<hr class="my-2">

<!-- Name Field -->
<div class="form-group">
    {!! Form::label('name', 'Name') !!}
    <p>{{ $hostingType->name }}</p>
</div>
<hr class="my-2">

<!-- Description Field -->
<div class="form-group">
    {!! Form::label('description', 'Description') !!}
    <p>{{ $hostingType->description }}</p>
</div>
<hr class="my-2">

<!-- Created At Field -->
<div class="form-group">
    {!! Form::label('created_at', 'Created At') !!}
    <p>{{ $hostingType->created_at }}</p>
</div>
<hr class="my-2">

<!-- Updated At Field -->
<div class="form-group">
    {!! Form::label('updated_at', 'Updated At') !!}
    <p>{{ $hostingType->updated_at }}</p>
</div>

