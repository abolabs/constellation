<!-- User Type Field -->
<div class="form-group col-sm-6">
    {!! Form::label('user_type', 'User Type:') !!}
    {!! Form::text('user_type', null, ['class' => 'form-control','maxlength' => 255,'maxlength' => 255]) !!}
</div>

<!-- User Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('user_id', 'User Id:') !!}
    {!! Form::number('user_id', null, ['class' => 'form-control']) !!}
</div>

<!-- Event Field -->
<div class="form-group col-sm-6">
    {!! Form::label('event', 'Event:') !!}
    {!! Form::text('event', null, ['class' => 'form-control','maxlength' => 255,'maxlength' => 255]) !!}
</div>

<!-- Auditable Type Field -->
<div class="form-group col-sm-6">
    {!! Form::label('auditable_type', 'Auditable Type:') !!}
    {!! Form::text('auditable_type', null, ['class' => 'form-control','maxlength' => 255,'maxlength' => 255]) !!}
</div>

<!-- Auditable Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('auditable_id', 'Auditable Id:') !!}
    {!! Form::number('auditable_id', null, ['class' => 'form-control']) !!}
</div>

<!-- Old Values Field -->
<div class="form-group col-sm-12 col-lg-12">
    {!! Form::label('old_values', 'Old Values:') !!}
    {!! Form::textarea('old_values', null, ['class' => 'form-control']) !!}
</div>

<!-- New Values Field -->
<div class="form-group col-sm-12 col-lg-12">
    {!! Form::label('new_values', 'New Values:') !!}
    {!! Form::textarea('new_values', null, ['class' => 'form-control']) !!}
</div>

<!-- Url Field -->
<div class="form-group col-sm-12 col-lg-12">
    {!! Form::label('url', 'Url:') !!}
    {!! Form::textarea('url', null, ['class' => 'form-control']) !!}
</div>

<!-- Ip Address Field -->
<div class="form-group col-sm-6">
    {!! Form::label('ip_address', 'Ip Address:') !!}
    {!! Form::text('ip_address', null, ['class' => 'form-control','maxlength' => 45,'maxlength' => 45]) !!}
</div>

<!-- User Agent Field -->
<div class="form-group col-sm-6">
    {!! Form::label('user_agent', 'User Agent:') !!}
    {!! Form::text('user_agent', null, ['class' => 'form-control','maxlength' => 1023,'maxlength' => 1023]) !!}
</div>

<!-- Tags Field -->
<div class="form-group col-sm-6">
    {!! Form::label('tags', 'Tags:') !!}
    {!! Form::text('tags', null, ['class' => 'form-control','maxlength' => 255,'maxlength' => 255]) !!}
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    <a href="{{ route('audits.index') }}" class="btn btn-secondary">Cancel</a>
</div>
