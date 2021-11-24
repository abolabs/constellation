<div class="container-fluid">
    <div class="animated fadeIn">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header text-white bg-secondary">
                        <strong>{{ $title }}</strong>
                        <a class="pull-right" href="#" data-toggle="modal" data-target="#new{{ $instanceKey }}Modal"><i class="fa fa-plus-square fa-lg pull-right"></i></a>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            @forelse($instanceDependencies as $index => $instanceDependencie)
                            <div class="col-sm-6 col-md-4 col-lg-3">
                                <div class="card">
                                    <div class="card-header text-white bg-primary">
                                        {{ $instanceDependencie[$instanceKey]->serviceVersion->service->name }}
                                        <div class="col-1 pull-right">
                                            {!! Form::open(['route' => ['serviceInstanceDependencies.destroy', $instanceDependencie->id], 'method' => 'delete']) !!}
                                                <input type="hidden" name="redirect_to_back" value="1" />
                                                <button type="submit" class="btn btn-transparent btn-sm" onclick="return confirm('Are you sure?')"><span class="badge badge-warning"><i class="fa fa-trash"></i></span></button>
                                            {!! Form::close() !!}
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div class="form-group">
                                            <p>
                                                <!-- Statut Id -->
                                                <span class="badge badge-info">Id: {{ $instanceDependencie[$instanceKey]->id }}</span>
                                                <!-- Statut Field -->
                                                @if ($instanceDependencie[$instanceKey]->statut == 1)
                                                    <span class="badge badge-success">Statut: Active</span>
                                                @else
                                                <span class="badge badge-warning">Statut: Inactive</span>
                                                @endif
                                                <!-- Version Field -->
                                                <span class="badge badge-secondary">Version {{ $instanceDependencie[$instanceKey]->serviceVersion->version }}</span>
                                            </p>
                                            <!-- application Field -->
                                            {!! Form::label('application', 'Application') !!}
                                            <p>{{ $instanceDependencie[$instanceKey]->application->name }}</p>
                                            <!-- Hosting Field -->
                                            {!! Form::label('hosting', 'Hosting') !!}
                                            <p>{{ $instanceDependencie[$instanceKey]->hosting->name }}</p>
                                            <!-- Environnement Field -->
                                            {!! Form::label('git_repo', 'Repository') !!}
                                            <p>
                                                <a href="{{ $instanceDependencie[$instanceKey]->serviceVersion->service->git_repo }}" target="blank">
                                                {{ $instanceDependencie->serviceInstance->serviceVersion->service->git_repo }}  <i class="cil-external-link"></i>
                                                </a>
                                            </p>
                                        </div>
                                    </div>
                                    <div class="card-footer p-x-1 py-h">
                                        <a class="font-weight-bold font-xs btn-block text-muted" href="/serviceInstances/{{ $instanceDependencie[$instanceKey]->id }}">
                                            <small class="text-muted">Voir plus <i class="fa fa-angle-right float-right font-lg"></i></small>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            @empty
                            <p>
                                @if($instanceKey == 'serviceInstanceDep')
                                L'instance ne requière aucune dépendance.
                                @else
                                Aucune instance de service ne requière l'instance.
                                @endif
                            </p>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="new{{ $instanceKey }}Modal" role="dialog" aria-labelledby="new{{ $instanceKey }}ModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
        <div class="modal-header bg-primary">
            <h5 class="modal-title" id="new{{ $instanceKey }}ModalLabel">Ajouter une nouvelle dépendance</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        {!! Form::open(['route' => 'serviceInstanceDependencies.store']) !!}
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
