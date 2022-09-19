<!-- Name Field -->
<div class="form-group col-sm-6">
    {!! Form::label('name', \Lang::get('hosting_type.name')) !!}
    {!! Form::text('name', null, ['class' => 'form-control']) !!}
</div>

<!-- Description Field -->
<div class="form-group col-sm-6">
    {!! Form::label('description', \Lang::get('hosting_type.description')) !!}
    {!! Form::text('description', null, ['class' => 'form-control']) !!}
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit(\Lang::get('common.save'), ['class' => 'btn btn-primary']) !!}
    <a href="{{ route('hostingTypes.index') }}" class="btn btn-secondary">{{ __('common.back') }}</a>
</div>
