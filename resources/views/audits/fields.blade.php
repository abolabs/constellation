<!-- User Type Field -->
<div class="form-group col-sm-6">
    {!! Form::label('user_type', \Lang::get('audit.user_type').':') !!}
    {!! Form::text('user_type', null, ['class' => 'form-control','maxlength' => 255,'maxlength' => 255]) !!}
</div>

<!-- User Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('user_id', \Lang::get('audit.user_id').':') !!}
    {!! Form::number('user_id', null, ['class' => 'form-control']) !!}
</div>

<!-- Event Field -->
<div class="form-group col-sm-6">
    {!! Form::label('event', \Lang::get('audit.event').':') !!}
    {!! Form::text('event', null, ['class' => 'form-control','maxlength' => 255,'maxlength' => 255]) !!}
</div>

<!-- Auditable Type Field -->
<div class="form-group col-sm-6">
    {!! Form::label('auditable_type', \Lang::get('audit.auditable_type').':') !!}
    {!! Form::text('auditable_type', null, ['class' => 'form-control','maxlength' => 255,'maxlength' => 255]) !!}
</div>

<!-- Auditable Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('auditable_id', \Lang::get('audit.auditable_id').':') !!}
    {!! Form::number('auditable_id', null, ['class' => 'form-control']) !!}
</div>

<!-- Old Values Field -->
<div class="form-group col-sm-12 col-lg-12">
    {!! Form::label('old_values', \Lang::get('audit.old_values').':') !!}
    {!! Form::textarea('old_values', null, ['class' => 'form-control']) !!}
</div>

<!-- New Values Field -->
<div class="form-group col-sm-12 col-lg-12">
    {!! Form::label('new_values', \Lang::get('audit.new_values').':') !!}
    {!! Form::textarea('new_values', null, ['class' => 'form-control']) !!}
</div>

<!-- Url Field -->
<div class="form-group col-sm-12 col-lg-12">
    {!! Form::label('url', \Lang::get('audit.url').':') !!}
    {!! Form::textarea('url', null, ['class' => 'form-control']) !!}
</div>

<!-- Ip Address Field -->
<div class="form-group col-sm-6">
    {!! Form::label('ip_address', \Lang::get('audit.ip').':') !!}
    {!! Form::text('ip_address', null, ['class' => 'form-control','maxlength' => 45,'maxlength' => 45]) !!}
</div>

<!-- User Agent Field -->
<div class="form-group col-sm-6">
    {!! Form::label('user_agent', \Lang::get('audit.user_agent').':') !!}
    {!! Form::text('user_agent', null, ['class' => 'form-control','maxlength' => 1023,'maxlength' => 1023]) !!}
</div>

<!-- Tags Field -->
<div class="form-group col-sm-6">
    {!! Form::label('tags', \Lang::get('audit.tags').':') !!}
    {!! Form::text('tags', null, ['class' => 'form-control','maxlength' => 255,'maxlength' => 255]) !!}
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit(\Lang::get('common.save'), ['class' => 'btn btn-primary']) !!}
    <a href="{{ route('audits.index') }}" class="btn btn-secondary">Cancel</a>
</div>
