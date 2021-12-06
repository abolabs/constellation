<!-- Id Field -->
<div class="form-group col-lg-3">
    {!! Form::label('id', \Lang::get('application.id')) !!}
    <p>{{ $application->id }}</p>
</div>

<!-- Team Id Field -->
<div class="form-group col-lg-3">
    {!! Form::label('team_name', \Lang::get('application.team')) !!}
    <p>{{ $application->team->name }}</p>
</div>

<!-- Created At Field -->
<div class="form-group col-lg-3">
    {!! Form::label('created_at', \Lang::get('common.field_created_at')) !!}
    <p>{{ $application->created_at }}</p>
</div>

<!-- Updated At Field -->
<div class="form-group col-lg-3">
    {!! Form::label('updated_at',  \Lang::get('common.field_updated_at')) !!}
    <p>{{ $application->updated_at }}</p>
</div>

