<div class="container-fluid">
    <div class="animated fadeIn">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header text-white bg-secondary">
                        <strong>{{ $title }}</strong>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            @foreach($instanceDependencies as $index => $instanceDependencie)
                            <div class="col-sm-6 col-md-4 col-lg-3">
                                <div class="card">
                                    <div class="card-header text-white bg-primary">
                                        {{ $instanceDependencie[$instanceKey]->serviceVersion->service->name }}
                                        <span class="badge badge-pill badge-secondary float-right">version {{ $instanceDependencie[$instanceKey]->serviceVersion->version }}</span>
                                    </div>
                                    <div class="card-body">
                                        <div class="form-group">
                                            <!-- Environnement Field -->
                                            {!! Form::label('application', 'Application') !!}
                                            <p>{{ $instanceDependencie[$instanceKey]->application->name }}</p>
                                            <!-- Environnement Field -->
                                            {!! Form::label('git_repo', 'Repository') !!}
                                            <p>
                                                <a href="{{ $instanceDependencie[$instanceKey]->serviceVersion->service->git_repo }}" target="blank">
                                                {{ $instanceDependencie->appInstance->serviceVersion->service->git_repo }}  <i class="cil-external-link"></i>
                                                </a>
                                            </p>
                                            <!-- Statut Field -->
                                            {!! Form::label('statut', 'Statut') !!}
                                            <p>
                                                @if ($instanceDependencie[$instanceKey]->statut == 1)
                                                    <span class="badge badge-success">Active</span>
                                                @else
                                                <span class="badge badge-warning">Inactive</span>
                                                @endif
                                            </p>
                                        </div>
                                    </div>
                                    <div class="card-footer p-x-1 py-h">
                                        <a class="font-weight-bold font-xs btn-block text-muted" href="/appInstances/{{ $instanceDependencie[$instanceKey]->id }}">Voir plus <i class="fa fa-angle-right float-right font-lg"></i></a>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
