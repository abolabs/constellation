@extends('layouts.app')

@section('content')
<ol class="breadcrumb">
    <li class="breadcrumb-item">
        <a href="{{ route('hostings.index') }}">{{ __('hosting.title') }}</a>
    </li>
    <li class="breadcrumb-item active">{{ __('common.details') }}</li>
</ol>
<div class="container-fluid">
    <div class="animated fadeIn">
        @include('coreui-templates::common.errors')
        <div class="row">
            <div class="col-lg-12">
                <h3>{{ $hosting->name }}</h3>
                <div class="card">
                    <div class="card-header text-white bg-secondary">
                        <strong>{{ __('common.details') }}</strong>
                        (<a href="{{ route('hostings.edit', $hosting->id ) }}" class="text-light">{{ __('datatable.edit') }}</a>)
                        <a href="{{ route('hostings.index') }}" class="btn btn-light pull-right">{{ __('common.back') }}</a>
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
                        <strong>{{ __('infra.service_instances') }}</strong>
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
                                                <span class="badge badge-info">{{ __('infra.id') }}: {{ $instance->id }}</span>
                                                <!-- Statut Field -->
                                                @if ($instance->statut == 1)
                                                <span class="badge badge-success">{{ __('infra.status') }}: {{ __('infra.active') }}</span>
                                                @else
                                                <span class="badge badge-warning">{{ __('infra.status') }}: {{ __('infra.inactive') }}</span>
                                                @endif
                                                <!-- Version Field -->
                                                <span class="badge badge-secondary">{{ __('infra.version') }} {{
                                                    $instance->serviceVersion->version }}</span>
                                            </p>
                                            <!-- application Field -->
                                            {!! Form::label('application', \Lang::get('infra.application')) !!}
                                            <p><a href="/applications/{{ $instance->application_id}}">{{
                                                    $instance->application->name }}</a></p>
                                            <!-- Environnement Field -->
                                            {!! Form::label('environnement', \Lang::get('infra.environnement')) !!}
                                            <p>{{ $instance->environnement->name }}</p>
                                            <!-- Environnement Field -->
                                            {!! Form::label('git_repo', \Lang::get('infra.git_repo')) !!}
                                            <p>
                                                <a href="{{ $instance->serviceVersion->service->git_repo }}"
                                                    target="blank">
                                                    {{ $instance->serviceVersion->service->git_repo }} <i
                                                        class="cil-external-link"></i>
                                                </a>
                                            </p>
                                        </div>
                                    </div>
                                    <div class="card-footer p-x-1 py-h">
                                        <a class="font-weight-bold font-xs btn-block text-muted"
                                            href="/serviceInstances/{{ $instance->id }}">
                                            <small class="text-muted">{{ __('infra.view_more') }} <i
                                                    class="fa fa-angle-right float-right font-lg"></i></small>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            @empty
                            <p>
                                {{ __('hosting.no_intance') }}
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
