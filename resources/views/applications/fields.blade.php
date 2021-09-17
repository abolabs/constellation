<!-- Name Field -->
<div class="form-group col-sm-6">
    {!! Form::label('name', 'Name:') !!}
    {!! Form::text('name', null, ['class' => 'form-control']) !!}
</div>

<!-- Team Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('team_id', 'Team Id:') !!}    
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
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    <a href="{{ route('applications.index') }}" class="btn btn-secondary">Cancel</a>
</div>
