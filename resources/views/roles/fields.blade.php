<!-- Name Field -->
<div class="form-group col-sm-6">
    {!! Form::label('name', \Lang::get('role.name')) !!}
    {!! Form::text('name', null, array('placeholder' => 'Name','class' => 'form-control')) !!}
</div>

<!-- Permission Field -->
<div class="col-xs-12 col-sm-12 col-md-12 form-group">
    {!! Form::label('permission', \Lang::get('role.permission')) !!}
    <br />
    @foreach($permission as $value)
        <p>{{ Form::checkbox('permission[]', $value->id, isset($rolePermissions) && in_array($value->id, $rolePermissions) ? true : false, array('class' => 'name')) }}
        {{ $value->name }}</p>
    @endforeach
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit(\Lang::get('common.save'), ['class' => 'btn btn-primary']) !!}
    <a href="{{ route('roles.index') }}" class="btn btn-secondary">{{ __('common.back') }}</a>
</div>
