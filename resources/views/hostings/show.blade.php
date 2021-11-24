@extends('layouts.app')

@section('content')
     <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('hostings.index') }}">Hosting</a>
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
                                <a href="{{ route('hostings.edit', $hosting->id ) }}" class="btn btn-light">Edit</a>
                                <a href="{{ route('hostings.index') }}" class="btn btn-light pull-right">Back</a>
                             </div>
                             <div class="card-body row">
                                 @include('hostings.show_fields')
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
                            <strong>Instances</strong>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                @forelse($instances as $index => $instance)
                                <div class="col-sm-6 col-md-4 col-lg-3">
                                    <div class="card">
                                        <div class="card-header text-white bg-primary">
                                            {{ $instance->serviceVersion->service->name }}
                                        </div>
                                        <div class="card-body">
                                            <div class="form-group">
                                                <p>
                                                    <!-- Statut Id -->
                                                    <span class="badge badge-info">Id: {{ $instance->id }}</span>
                                                    <!-- Statut Field -->
                                                    @if ($instance->statut == 1)
                                                        <span class="badge badge-success">Statut: Active</span>
                                                    @else
                                                    <span class="badge badge-warning">Statut: Inactive</span>
                                                    @endif
                                                    <!-- Version Field -->
                                                    <span class="badge badge-secondary">Version {{ $instance->serviceVersion->version }}</span>
                                                </p>
                                                <!-- application Field -->
                                                {!! Form::label('application', 'Application') !!}
                                                <p><a href="/applications/{{ $instance->application_id}}">{{ $instance->application->name }}</a></p>
                                                <!-- Environnement Field -->
                                                {!! Form::label('environnement', 'Environnement') !!}
                                                <p>{{ $instance->environnement->name }}</p>
                                                <!-- Environnement Field -->
                                                {!! Form::label('git_repo', 'Repository') !!}
                                                <p>
                                                    <a href="{{ $instance->serviceVersion->service->git_repo }}" target="blank">
                                                    {{ $instance->serviceVersion->service->git_repo }}  <i class="cil-external-link"></i>
                                                    </a>
                                                </p>
                                            </div>
                                        </div>
                                        <div class="card-footer p-x-1 py-h">
                                            <a class="font-weight-bold font-xs btn-block text-muted" href="/serviceInstances/{{ $instance->id }}">
                                                <small class="text-muted">Voir plus <i class="fa fa-angle-right float-right font-lg"></i></small>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                @empty
                                <p>
                                    Aucune instance n'est actuellement présente sur la solution d'hébergement.
                                </p>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
