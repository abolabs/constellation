@extends('layouts.app')

@section('content')
     <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('serviceInstances.index') }}">{{ __('infra.service_instances') }}</a>
            </li>
            <li class="breadcrumb-item active">{{ __('common.details') }}</li>
     </ol>
     <div class="container-fluid">
          <div class="animated fadeIn">
                 @include('coreui-templates::common.errors')
                 <div class="row">
                     <div class="col-lg-12">
                        <h3><a href="{{ route('applications.show',[$serviceInstance->application->id ]) }}">{{ $serviceInstance->application->name }}</a> / {{ $serviceInstance->serviceVersion->service->name }}</h3>
                        <h5 class="font-italic">{{ $serviceInstance->environnement->name }} / {{ $serviceInstance->hosting->name }}</h5>
                        <div class="card">
                             <div class="card-header text-white bg-secondary">
                                <strong>{{ __('common.details') }}</strong>
                                (<a href="{{ route('serviceInstances.edit', $serviceInstance->id ) }}" class="text-light">{{ __('datatable.edit') }}</a>)
                                <a href="{{ route('serviceInstances.index') }}" class="btn btn-light pull-right">{{ __('common.back') }}</a>
                             </div>
                             <div class="card-body row">
                                 @include('service_instances.show_fields')
                             </div>
                         </div>
                     </div>
                 </div>
          </div>
    </div>
    @include('service_instances.show_dependencies',[
        'title' => \Lang::get('infra.dependencies'),
        'instanceDependencies' => $instanceDependencies,
        'instanceKey' => 'serviceInstanceDep'
    ])

    @include('service_instances.show_dependencies',[
        'title' => \Lang::get('infra.required_by'),
        'instanceDependencies' => $instanceDependenciesSource,
        'instanceKey' => 'serviceInstance'
    ])
@endsection
