<!-- User Type Field -->
<div class="form-group">
    {!! Form::label('user_type', 'User Type:') !!}
    <p>{{ $audit->user_type }}</p>
</div>

<!-- User Id Field -->
<div class="form-group">
    {!! Form::label('user_id', 'User Id:') !!}
    <p>{{ $audit->user_id }}</p>
</div>

<!-- Event Field -->
<div class="form-group">
    {!! Form::label('event', 'Event:') !!}
    <p>{{ $audit->event }}</p>
</div>

<!-- Auditable Type Field -->
<div class="form-group">
    {!! Form::label('auditable_type', 'Auditable Type:') !!}
    <p>{{ $audit->auditable_type }}</p>
</div>

<!-- Auditable Id Field -->
<div class="form-group">
    {!! Form::label('auditable_id', 'Auditable Id:') !!}
    <p>{{ $audit->auditable_id }}</p>
</div>

<!-- Old Values Field -->
<div class="form-group">
    {!! Form::label('old_values', 'Old Values:') !!}
    <p>{{ $audit->old_values }}</p>
</div>

<!-- New Values Field -->
<div class="form-group">
    {!! Form::label('new_values', 'New Values:') !!}
    <p>{{ $audit->new_values }}</p>
</div>

<!-- Url Field -->
<div class="form-group">
    {!! Form::label('url', 'Url:') !!}
    <p>{{ $audit->url }}</p>
</div>

<!-- Ip Address Field -->
<div class="form-group">
    {!! Form::label('ip_address', 'Ip Address:') !!}
    <p>{{ $audit->ip_address }}</p>
</div>

<!-- User Agent Field -->
<div class="form-group">
    {!! Form::label('user_agent', 'User Agent:') !!}
    <p>{{ $audit->user_agent }}</p>
</div>

<!-- Tags Field -->
<div class="form-group">
    {!! Form::label('tags', 'Tags:') !!}
    <p>{{ $audit->tags }}</p>
</div>

