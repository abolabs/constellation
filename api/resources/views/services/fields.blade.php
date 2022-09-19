<!-- Team Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('team_id', \Lang::get('infra.team') ) !!}
    <select name="team_id" id="team_id" class="form-control">
    @if (isset($service->team->id))
        <option value="{{$service->team->id}}">[{{$service->team->id}}] {{$service->team->name}}</option>
    @endif
    </select>
    <script>
        window.selector.make("#team_id", "/api/teams", "id", "name")
    </script>
</div>

<!-- Name Field -->
<div class="form-group col-sm-6">
    {!! Form::label('name', \Lang::get('infra.name') ) !!}
    {!! Form::text('name', null, ['class' => 'form-control']) !!}
</div>

<!-- Git Repo Field -->
<div class="form-group col-sm-6">
    {!! Form::label('git_repo', \Lang::get('infra.git_repo') ) !!}
    {!! Form::text('git_repo', null, ['class' => 'form-control']) !!}
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit(\Lang::get('common.save'), ['class' => 'btn btn-primary']) !!}
    <a href="{{ route('services.index') }}" class="btn btn-secondary">{{ __('common.back') }}</a>
</div>
