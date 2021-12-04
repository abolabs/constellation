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
                                                <!-- Role Field -->
                                                @if(isset($instanceDependencie[$instanceKey]->role)) <span class="badge badge-info">Role: {{ $instanceDependencie[$instanceKey]->role }}</span> @endif
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
                                                {{ $instanceDependencie[$instanceKey]->serviceVersion->service->git_repo }}  <i class="cil-external-link"></i>
                                                </a>
                                            </p>
                                            <hr class="my-2">
                                            <div class="form-group">
                                                <a class="pull-right" href="#" data-toggle="modal" data-target="#newEdition{{ $instanceDependencie->id }}Modal" data-id-dep="{{  $instanceDependencie[$instanceKey]->id }}">
                                                    <span class="badge badge-secondary"><i class="fa fa-pencil"></i></span>
                                                </a>
                                                <h5>Dépendance</h5>
                                                <p>
                                                    <!-- Level -->
                                                    <span class="badge badge-{{ __('service_instance_dependencies.level_bg.'.$instanceDependencie->level) }}" data-container="body" data-toggle="popover" data-trigger="hover" data-placement="top" data-content="{{ __('service_instance_dependencies.level_description.'.$instanceDependencie->level) }}">
                                                        Level: {{ __('service_instance_dependencies.level.'.$instanceDependencie->level) }}
                                                    </span>
                                                </p>
                                            </div>
                                            <!-- Description -->
                                            {!! Form::label('description', 'Description') !!}
                                            <p>{{ $instanceDependencie->description }}</p>

                                            @include('service_instances.show_dependencies_modal', [
                                                'instanceKey' => "Edition".$instanceDependencie->id,
                                                'serviceInstance' => $serviceInstance,
                                                'title' => 'Editer une nouvelle dépendance',
                                                'serviceInstanceDependencies' => $instanceDependencie,
                                            ])
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
@include('service_instances.show_dependencies_modal', [
    'instanceKey' => $instanceKey,
    'serviceInstance' => $serviceInstance,
    'title' => 'Ajouter une nouvelle dépendance'

])

<script>
    $(function () {
        $('[data-toggle="popover"]').popover()
    })
</script>
