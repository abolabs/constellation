<!-- Name Field -->
<div class="form-group col-sm-6">
    {!! Form::label('name', \Lang::get('environnement.name').':') !!}
    {!! Form::text('name', null, ['class' => 'form-control']) !!}
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit( \Lang::get('common.save') , ['class' => 'btn btn-primary']) !!}
    <a href="{{ route('environnements.index') }}" class="btn btn-secondary">{{ __('common.cancel') }}</a>
</div>
