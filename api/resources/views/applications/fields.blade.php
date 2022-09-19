<!-- Name Field -->
<div class="form-group col-sm-6">
    {!! Form::label('name', \Lang::get('application.name').' :') !!}
    {!! Form::text('name', null, ['class' => 'form-control']) !!}
</div>

<!-- Team Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('team_id', \Lang::get('application.team').' :') !!}
    <select name="team_id" id="team_id" class="form-control">
    @if (isset($application->team->id))
        <option value="{{$application->team->id}}">[{{$application->team->id}}] {{$application->team->name}}</option>
    @endif
    </select>
    <script>
        window.selector.make("#team_id", "/api/teams", "id", "name")
    </script>
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit(\Lang::get('common.save'), ['class' => 'btn btn-primary']) !!}
    <a href="{{ route('applications.index') }}" class="btn btn-secondary">{{ __('common.cancel') }}</a>
</div>
