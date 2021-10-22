<!-- Id Field -->
<div class="form-group">
    {!! Form::label('id', 'Id') !!}
    <p>{{ $service->id }}</p>
</div>
<hr class="my-2">

<!-- Team Id Field -->
<div class="form-group">
    {!! Form::label('team_name', 'Team') !!}
    <p>{{ $service->team->name }}</p>
</div>
<hr class="my-2">

<!-- Name Field -->
<div class="form-group">
    {!! Form::label('name', 'Name') !!}
    <p>{{ $service->name }}</p>
</div>
<hr class="my-2">

<!-- Git Repo Field -->
<div class="form-group">
    {!! Form::label('git_repo', 'Git Repo') !!}
    <p>{{ $service->git_repo }}</p>
</div>
<hr class="my-2">

<!-- Created At Field -->
<div class="form-group">
    {!! Form::label('created_at', 'Created At') !!}
    <p>{{ $service->created_at }}</p>
</div>
<hr class="my-2">

<!-- Updated At Field -->
<div class="form-group">
    {!! Form::label('updated_at', 'Updated At') !!}
    <p>{{ $service->updated_at }}</p>
</div>

