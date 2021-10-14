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
                            <a href="{{ route('applications.index') }}" class="btn btn-light">Back</a>
                        </div>
                        <div class="card-body">
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
                                <div class="col-lg-12">
                                    <div class="row">
                                        @foreach($appInstances as $appInstance)
                                        <div class="col-sm-6 col-md-3">
                                            <div class="card">
                                                <div class="card-header text-white bg-primary">
                                                    {{ $appInstance->serviceVersion->service->name }}
                                                    <span class="badge badge-pill badge-secondary float-right">version {{ $appInstance->serviceVersion->version }}</span>
                                                </div>
                                                <div class="card-body">
                                                    <div class="form-group">
                                                        <!-- Environnement Field -->
                                                        {!! Form::label('environnement', 'Environnement') !!}
                                                        <p>{{ $appInstance->environnement->name }}</p>
                                                        <!-- Environnement Field -->
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
    </div>
@endsection
