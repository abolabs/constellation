<!-- Id Field -->
<div class="form-group">
    {!! Form::label('id', \Lang::get('infra.id')) !!}
    <p>{{ $team->id }}</p>
</div>
<hr class="my-2">

<!-- Name Field -->
<div class="form-group">
    {!! Form::label('name', \Lang::get('infra.name')) !!}
    <p>{{ $team->name }}</p>
</div>
<hr class="my-2">

<!-- Manager Field -->
<div class="form-group">
    {!! Form::label('manager', \Lang::get('infra.manager')) !!}
    <p>{{ $team->manager }}</p>
</div>
<hr class="my-2">

<!-- Created At Field -->
<div class="form-group">
    {!! Form::label('created_at', \Lang::get('common.field_created_at')) !!}
    <p>{{ $team->created_at }}</p>
</div>
<hr class="my-2">

<!-- Updated At Field -->
<div class="form-group">
    {!! Form::label('updated_at', \Lang::get('common.field_updated_at')) !!}
    <p>{{ $team->updated_at }}</p>
</div>

