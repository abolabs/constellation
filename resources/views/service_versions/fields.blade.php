<!-- Service Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('service_id', 'Service:') !!}    
    <select name="service_id" id="service_id" class="form-control"></select>
    <script>
        window.selector.make("#service_id", "/api/services", "id", "name")    
    </script>       
</div>

<!-- Version Field -->
<div class="form-group col-sm-6">
    {!! Form::label('version', 'Version:') !!}
    {!! Form::text('version', null, ['class' => 'form-control']) !!}
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    <a href="{{ route('serviceVersions.index') }}" class="btn btn-secondary">Cancel</a>
</div>
