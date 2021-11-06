<!-- Id Field -->
<div class="form-group col-lg-3">
    {!! Form::label('id', 'Id') !!}
    <p>{{ $application->id }}</p>
</div>

<!-- Name Field -->
<div class="form-group col-lg-3">
    {!! Form::label('name', 'Name') !!}
    <p>{{ $application->name }}</p>
</div>

<!-- Team Id Field -->
<div class="form-group col-lg-3">
    {!! Form::label('team_name', 'Team') !!}
    <p>{{ $application->team->name }}</p>
</div>

<!-- Created At Field -->
<div class="form-group col-lg-3">
    {!! Form::label('created_at', 'Created At') !!}
    <p>{{ $application->created_at }}</p>
</div>

<!-- Updated At Field -->
<div class="form-group col-lg-3">
    {!! Form::label('updated_at', 'Updated At') !!}
    <p>{{ $application->updated_at }}</p>
</div>

