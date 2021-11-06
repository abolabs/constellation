<!-- Id Field -->
<div class="form-group col-lg-3">
    {!! Form::label('id', 'Id') !!}
    <p>{{ $service->id }}</p>
</div>

<!-- Team Id Field -->
<div class="form-group col-lg-3">
    {!! Form::label('team_name', 'Team') !!}
    <p>{{ $service->team->name }}</p>
</div>

<!-- Name Field -->
<div class="form-group col-lg-3">
    {!! Form::label('name', 'Name') !!}
    <p>{{ $service->name }}</p>
</div>

<!-- Git Repo Field -->
<div class="form-group col-lg-3">
    {!! Form::label('git_repo', 'Git Repo') !!}
    <p>{{ $service->git_repo }}</p>
</div>

<!-- Created At Field -->
<div class="form-group col-lg-3">
    {!! Form::label('created_at', 'Created At') !!}
    <p>{{ $service->created_at }}</p>
</div>

<!-- Updated At Field -->
<div class="form-group col-lg-3">
    {!! Form::label('updated_at', 'Updated At') !!}
    <p>{{ $service->updated_at }}</p>
</div>

