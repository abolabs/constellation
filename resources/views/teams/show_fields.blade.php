<!-- Id Field -->
<div class="form-group">
    {!! Form::label('id', 'Id') !!}
    <p>{{ $team->id }}</p>
</div>
<hr class="my-2">

<!-- Name Field -->
<div class="form-group">
    {!! Form::label('name', 'Name') !!}
    <p>{{ $team->name }}</p>
</div>
<hr class="my-2">

<!-- Manager Field -->
<div class="form-group">
    {!! Form::label('manager', 'Manager') !!}
    <p>{{ $team->manager }}</p>
</div>
<hr class="my-2">

<!-- Created At Field -->
<div class="form-group">
    {!! Form::label('created_at', 'Created At') !!}
    <p>{{ $team->created_at }}</p>
</div>
<hr class="my-2">

<!-- Updated At Field -->
<div class="form-group">
    {!! Form::label('updated_at', 'Updated At') !!}
    <p>{{ $team->updated_at }}</p>
</div>

