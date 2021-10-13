<!-- User Type Field -->
<div class="form-group">
    {!! Form::label('user_type', 'User Type') !!}
    <p>{{ $audit->user_type }}</p>
</div>
<hr class="my-2">

<!-- User Id Field -->
<div class="form-group">
    {!! Form::label('user_id', 'User Id') !!}
    <p>{{ $audit->user_id }}</p>
</div>
<hr class="my-2">

<!-- Event Field -->
<div class="form-group">
    {!! Form::label('event', 'Event') !!}
    <p>{{ $audit->event }}</p>
</div>
<hr class="my-2">

<!-- Auditable Type Field -->
<div class="form-group">
    {!! Form::label('auditable_type', 'Auditable Type') !!}
    <p>{{ $audit->auditable_type }}</p>
</div>
<hr class="my-2">

<!-- Auditable Id Field -->
<div class="form-group">
    {!! Form::label('auditable_id', 'Auditable Id') !!}
    <p>{{ $audit->auditable_id }}</p>
</div>
<hr class="my-2">

<!-- Old Values Field -->
<div class="form-group">
    {!! Form::label('old_values', 'Old Values') !!}
    <p>{{ $audit->old_values }}</p>
</div>
<hr class="my-2">

<!-- New Values Field -->
<div class="form-group">
    {!! Form::label('new_values', 'New Values') !!}
    <p>{{ $audit->new_values }}</p>
</div>
<hr class="my-2">

<!-- Url Field -->
<div class="form-group">
    {!! Form::label('url', 'Url') !!}
    <p>{{ $audit->url }}</p>
</div>
<hr class="my-2">

<!-- Ip Address Field -->
<div class="form-group">
    {!! Form::label('ip_address', 'Ip Address') !!}
    <p>{{ $audit->ip_address }}</p>
</div>
<hr class="my-2">

<!-- User Agent Field -->
<div class="form-group">
    {!! Form::label('user_agent', 'User Agent') !!}
    <p>{{ $audit->user_agent }}</p>
</div>
<hr class="my-2">

<!-- Tags Field -->
<div class="form-group">
    {!! Form::label('tags', 'Tags') !!}
    <p>{{ $audit->tags }}</p>
</div>


