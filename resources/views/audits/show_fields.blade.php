<!-- User Type Field -->
<div class="form-group">
    {!! Form::label('user_type', \Lang::get('audit.user_type')) !!}
    <p>{{ $audit->user_type }}</p>
</div>
<hr class="my-2">

<!-- User Id Field -->
<div class="form-group">
    {!! Form::label('user_id', \Lang::get('audit.user_id')) !!}
    <p>{{ $audit->user_id }}</p>
</div>
<hr class="my-2">

<!-- Event Field -->
<div class="form-group">
    {!! Form::label('event', \Lang::get('audit.event')) !!}
    <p>{{ $audit->event }}</p>
</div>
<hr class="my-2">

<!-- Auditable Type Field -->
<div class="form-group">
    {!! Form::label('auditable_type', \Lang::get('audit.auditable_type')) !!}
    <p>{{ $audit->auditable_type }}</p>
</div>
<hr class="my-2">

<!-- Auditable Id Field -->
<div class="form-group">
    {!! Form::label('auditable_id', \Lang::get('audit.auditable_id')) !!}
    <p>{{ $audit->auditable_id }}</p>
</div>
<hr class="my-2">

<!-- Old Values Field -->
<div class="form-group">
    {!! Form::label('old_values', \Lang::get('audit.old_values')) !!}
    <p>{{ $audit->old_values }}</p>
</div>
<hr class="my-2">

<!-- New Values Field -->
<div class="form-group">
    {!! Form::label('new_values', \Lang::get('audit.new_values')) !!}
    <p>{{ $audit->new_values }}</p>
</div>
<hr class="my-2">

<!-- Url Field -->
<div class="form-group">
    {!! Form::label('url', \Lang::get('audit.url')) !!}
    <p>{{ $audit->url }}</p>
</div>
<hr class="my-2">

<!-- Ip Address Field -->
<div class="form-group">
    {!! Form::label('ip_address', \Lang::get('audit.ip')) !!}
    <p>{{ $audit->ip_address }}</p>
</div>
<hr class="my-2">

<!-- User Agent Field -->
<div class="form-group">
    {!! Form::label('user_agent', \Lang::get('audit.user_agent')) !!}
    <p>{{ $audit->user_agent }}</p>
</div>
<hr class="my-2">

<!-- Tags Field -->
<div class="form-group">
    {!! Form::label('tags', \Lang::get('audit.tags')) !!}
    <p>{{ $audit->tags }}</p>
</div>


