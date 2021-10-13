<!-- Id Field -->
<div class="form-group">
    {!! Form::label('id', 'Id') !!}
    <p>{{ $application->id }}</p>
</div>
<hr class="my-2">

<!-- Name Field -->
<div class="form-group">
    {!! Form::label('name', 'Name') !!}
    <p>{{ $application->name }}</p>
</div>
<hr class="my-2">

<!-- Team Id Field -->
<div class="form-group">
    {!! Form::label('team_id', 'Team Id') !!}
    <p>{{ $application->team_id }}</p>
</div>
<hr class="my-2">

<!-- Created At Field -->
<div class="form-group">
    {!! Form::label('created_at', 'Created At') !!}
    <p>{{ $application->created_at }}</p>
</div>
<hr class="my-2">

<!-- Updated At Field -->
<div class="form-group">
    {!! Form::label('updated_at', 'Updated At') !!}
    <p>{{ $application->updated_at }}</p>
</div>

