@extends('layouts.app')

@section('content')
     <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('applications.index') }}">Application</a>
            </li>
            <li class="breadcrumb-item active">Detail</li>
     </ol>
     <div class="container-fluid">
        <div class="animated fadeIn">
            @include('coreui-templates::common.errors')
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header text-white bg-secondary">
                            <strong>Details</strong>
                            <a href="{{ route('applications.edit', $application->id ) }}" class="btn btn-light">Edit</a>
                            <a href="{{ route('applications.index') }}" class="btn btn-light pull-right">Back</a>
                        </div>
                        <div class="card-body row">
                            @include('applications.show_fields')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid">
        <div class="animated fadeIn">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header text-white bg-secondary">
                            <strong>Instances de services</strong>
                            <a class="pull-right" href="#" data-toggle="modal" data-target="#newServiceVersionModal"><i class="fa fa-plus-square fa-lg pull-right"></i></a>
                        </div>

                        <div class="card-body">
                            <div class="row">

                                @if (count($serviceInstances) > 0)
                                <div class="nav flex-column nav-pills col-lg-2" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                                    @foreach($serviceInstances as $index => $serviceInstance)
                                        @if(!isset($serviceInstances[$index-1]) || $serviceInstances[$index-1]->environnement_id != $serviceInstance->environnement_id)
                                            <a class="nav-link @if($index == 0) active @endif" id="v-pills-{{$serviceInstance->environnement_id}}-tab" data-toggle="pill"
                                                href="#v-pills-{{$serviceInstance->environnement_id}}" role="tab"
                                                aria-controls="v-pills-{{$serviceInstance->environnement_id}}" aria-selected="true">{{ $serviceInstance->environnement->name }} <span class="badge badge-light pull-right">{{ $countByEnv[$serviceInstance->environnement_id]['service_instances_count'] }}</span></a>
                                        @endif
                                    @endforeach
                                </div>

                                <div class="tab-content col-lg-10" id="v-pills-tabContent">
                                    @foreach($serviceInstances as $index => $serviceInstance)
                                        @if( $index > 0 && $serviceInstances[$index-1]->environnement_id != $serviceInstance->environnement_id)
                                                </div>
                                            </div>
                                            @endif
                                        @if( $index == 0 || $serviceInstances[$index-1]->environnement_id != $serviceInstance->environnement_id)
                                            <div class="tab-pane fade show @if($index == 0) active @endif" id="v-pills-{{$serviceInstance->environnement_id}}" role="tabpanel" aria-labelledby="v-pills-{{$serviceInstance->environnement_id}}-tab">
                                                <div class="row">
                                        @endif
                                        <div class="col-sm-12 col-md-6 col-lg-4">
                                            <div class="card">
                                                <div class="card-header text-white bg-primary">
                                                    {{ $serviceInstance->serviceVersion->service->name }}
                                                    <span class="badge badge-pill badge-secondary float-right">version {{ $serviceInstance->serviceVersion->version }}</span>
                                                </div>
                                                <div class="card-body">
                                                    <div class="form-group">
                                                        <p>
                                                            <!-- Statut Id -->
                                                            <span class="badge badge-info">Id: {{ $serviceInstance->id }}</span>
                                                            <!-- Statut Field -->
                                                            @if ($serviceInstance->statut == 1)
                                                                <span class="badge badge-success">Statut: Active</span>
                                                            @else
                                                            <span class="badge badge-warning">Statut: Inactive</span>
                                                            @endif
                                                            @if ($serviceInstance->role)
                                                            <span class="badge badge-secondary">Role: {{ $serviceInstance->role }}</span>
                                                            @endif
                                                        </p>
                                                        <!-- Environnement Field -->
                                                        {!! Form::label('git_repo', 'Repository') !!}
                                                        <p><a href="{{ $serviceInstance->serviceVersion->service->git_repo }}" target="blank">{{ $serviceInstance->serviceVersion->service->git_repo }}  <i class="cil-external-link"></i> </a></p>
                                                    </div>
                                                </div>
                                                <div class="card-footer p-x-1 py-h">
                                                    <a class="font-weight-bold font-xs btn-block text-muted" href="/serviceInstances/{{ $serviceInstance->id }}">
                                                        <small class="text-muted">Voir plus <i class="fa fa-angle-right float-right font-lg"></i></small>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                                @else
                                <p>{{ __('application.no_service') }}</p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="newServiceVersionModal" role="dialog" aria-labelledby="newVersionModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h5 class="modal-title" id="newServiceVersionModalLabel">Ajouter une nouvelle instance de service</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            {!! Form::open(['route' => 'serviceInstances.store']) !!}
            <div class="modal-body">

                <!-- Application id -->
                <input type="hidden" name="application_id" value="{{ $application->id }}" />
                <input type="hidden" name="redirect_to_back" value="1" />

                @include('service_instances.fields', ['noButton' => true, 'ignoreApp' => true])
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
            </div>
            {!! Form::close() !!}
        </div>
        </div>
    </div>
@endsection
