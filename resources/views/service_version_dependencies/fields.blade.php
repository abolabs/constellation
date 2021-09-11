<!-- Service Version Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('service_version_id', 'Service Version Id:') !!}    
    <select name="service_version_id" id="service_version_id" class="form-control"></select>
    <script>
        window.selector.make("#service_version_id", "/api/serviceVersions", "id", "version")    
    </script>       
</div>

<!-- Service Version Dependency Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('service_version_dependency_id', 'Service Version Dependency Id:') !!}    
    <select name="service_version_dependency_id" id="service_version_dependency_id" class="form-control"></select>
    <script>
        window.selector.make("#service_version_dependency_id", "/api/services", "id", "name")    
    </script>   
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    <a href="{{ route('serviceVersionDependencies.index') }}" class="btn btn-secondary">Cancel</a>
</div>
