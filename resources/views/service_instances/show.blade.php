@extends('layouts.app')

@section('content')
     <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('serviceInstances.index') }}">Service Instance</a>
            </li>
            <li class="breadcrumb-item active">Detail</li>
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
                                <strong>Details</strong>
                                <a href="{{ route('serviceInstances.edit', $serviceInstance->id ) }}" class="btn btn-light">Edit</a>
                                <a href="{{ route('serviceInstances.index') }}" class="btn btn-light pull-right">Back</a>
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
        'title' => 'Dépendances',
        'instanceDependencies' => $instanceDependencies,
        'instanceKey' => 'serviceInstanceDep'
    ])

    @include('service_instances.show_dependencies',[
        'title' => 'Requis par',
        'instanceDependencies' => $instanceDependenciesSource,
        'instanceKey' => 'serviceInstance'
    ])
@endsection
