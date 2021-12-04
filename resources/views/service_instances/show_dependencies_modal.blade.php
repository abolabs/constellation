<!-- Modal -->
<div class="modal fade @if( isset($serviceInstanceDependencies)) modal-dep-edit @endif" id="new{{ $instanceKey }}Modal" role="dialog" aria-labelledby="new{{ $instanceKey }}ModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
        <div class="modal-header bg-primary">
            <h5 class="modal-title" id="new{{ $instanceKey }}ModalLabel">{{ $title }}</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        @if( isset($serviceInstanceDependencies))
        {!! Form::model($serviceInstanceDependencies, ['route' => ['serviceInstanceDependencies.update', $serviceInstanceDependencies->id], 'method' => 'patch']) !!}
        @else
        {!! Form::open(['route' => 'serviceInstanceDependencies.store']) !!}
        @endif
        <div class="modal-body">

            <!-- Application id -->
            <input type="hidden" name="redirect_to_back" value="1" />
            @if($instanceKey == 'serviceInstanceDep')
                <input type="hidden" name="instance_id" value="{{ $serviceInstance->id }}" />
                @include('service_instance_dependencies.fields', ['noButton' => true, 'ignoreSourceInstance' => true])
            @else
                <input type="hidden" name="instance_dep_id" value="{{ $serviceInstance->id }}" />
                @include('service_instance_dependencies.fields', ['noButton' => true, 'ignoreTargetInstance' => true])
            @endif
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
        </div>
        {!! Form::close() !!}
    </div>
    </div>
</div>
