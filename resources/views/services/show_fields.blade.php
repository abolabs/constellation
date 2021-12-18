<!-- Id Field -->
<div class="form-group col-lg-3">
    {!! Form::label('id', \Lang::get('infra.id') ) !!}
    <p>{{ $service->id }}</p>
</div>

<!-- Team Id Field -->
<div class="form-group col-lg-3">
    {!! Form::label('team_name', \Lang::get('infra.team')) !!}
    <p>{{ $service->team->name }}</p>
</div>

<!-- Git Repo Field -->
<div class="form-group col-lg-3">
    {!! Form::label('git_repo', \Lang::get('infra.git_repo')) !!}
    <p>{{ $service->git_repo }}</p>
</div>

<!-- Created At Field -->
<div class="form-group col-lg-3">
    {!! Form::label('created_at', \Lang::get('common.field_created_at')) !!}
    <p>{{ $service->created_at }}</p>
</div>

<!-- Updated At Field -->
<div class="form-group col-lg-3">
    {!! Form::label('updated_at', \Lang::get('common.field_updated_at')) !!}
    <p>{{ $service->updated_at }}</p>
</div>

