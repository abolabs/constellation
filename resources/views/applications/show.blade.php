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
            @include('coreui-templates::common.errors')
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header text-white bg-secondary">
                            <strong>Instances de services</strong>
                        </div>
                        <div class="card-body">
                            <div class="row">

                                <div class="nav flex-column nav-pills col-lg-2" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                                    @foreach($appInstances as $index => $appInstance)
                                        @if(!isset($appInstances[$index-1]) || $appInstances[$index-1]->environnement_id != $appInstance->environnement_id)
                                            <a class="nav-link @if($index == 0) active @endif" id="v-pills-{{$appInstance->environnement_id}}-tab" data-toggle="pill"
                                                href="#v-pills-{{$appInstance->environnement_id}}" role="tab"
                                                aria-controls="v-pills-{{$appInstance->environnement_id}}" aria-selected="true">{{ $appInstance->environnement->name }}</a>
                                        @endif
                                    @endforeach
                                </div>

                                <div class="tab-content col-lg-10" id="v-pills-tabContent">
                                    @foreach($appInstances as $index => $appInstance)
                                        @if( $index > 0 && $appInstances[$index-1]->environnement_id != $appInstance->environnement_id)
                                                </div>
                                            </div>
                                            @endif
                                        @if( $index == 0 || $appInstances[$index-1]->environnement_id != $appInstance->environnement_id)
                                            <div class="tab-pane fade show @if($index == 0) active @endif" id="v-pills-{{$appInstance->environnement_id}}" role="tabpanel" aria-labelledby="v-pills-{{$appInstance->environnement_id}}-tab">
                                                <div class="row">
                                        @endif
                                        <div class="col-sm-12 col-md-6 col-lg-4">
                                            <div class="card">
                                                <div class="card-header text-white bg-primary">
                                                    {{ $appInstance->serviceVersion->service->name }}
                                                    <span class="badge badge-pill badge-secondary float-right">version {{ $appInstance->serviceVersion->version }}</span>
                                                </div>
                                                <div class="card-body">
                                                    <div class="form-group">
                                                        <!-- Id Field -->
                                                        {!! Form::label('appInstance_id', 'Id') !!}
                                                        <p>{{ $appInstance->id }}</p>

                                                        <!-- Environnement Field -->
                                                        {!! Form::label('git_repo', 'Repository') !!}
                                                        <p><a href="{{ $appInstance->serviceVersion->service->git_repo }}" target="blank">{{ $appInstance->serviceVersion->service->git_repo }}  <i class="cil-external-link"></i> </a></p>
                                                        <!-- Statut Field -->
                                                        {!! Form::label('statut', 'Statut') !!}
                                                        <p>
                                                            @if ($appInstance->statut == 1)
                                                                <span class="badge badge-success">Active</span>
                                                            @else
                                                            <span class="badge badge-warning">Inactive</span>
                                                            @endif
                                                        </p>
                                                    </div>
                                                </div>
                                                <div class="card-footer p-x-1 py-h">
                                                    <a class="font-weight-bold font-xs btn-block text-muted" href="/appInstances/{{ $appInstance->id }}">Voir plus <i class="fa fa-angle-right float-right font-lg"></i></a>
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
    </div>
@endsection
