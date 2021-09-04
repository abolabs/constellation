<!-- Id Field -->
<div class="form-group">
    {!! Form::label('id', 'Id:') !!}
    <p>{{ $service->id }}</p>
</div>

<!-- Team Id Field -->
<div class="form-group">
    {!! Form::label('team_id', 'Team Id:') !!}
    <p>{{ $service->team_id }}</p>
</div>

<!-- Name Field -->
<div class="form-group">
    {!! Form::label('name', 'Name:') !!}
    <p>{{ $service->name }}</p>
</div>

<!-- Git Repo Field -->
<div class="form-group">
    {!! Form::label('git_repo', 'Git Repo:') !!}
    <p>{{ $service->git_repo }}</p>
</div>

<!-- Created At Field -->
<div class="form-group">
    {!! Form::label('created_at', 'Created At:') !!}
    <p>{{ $service->created_at }}</p>
</div>

<!-- Updated At Field -->
<div class="form-group">
    {!! Form::label('updated_at', 'Updated At:') !!}
    <p>{{ $service->updated_at }}</p>
</div>

