@extends('layouts.app')

@section('content')
     <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('serviceVersionDependencies.index') }}">Service Version Dependencies</a>
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
                                  <a href="{{ route('serviceVersionDependencies.index') }}" class="btn btn-light">Back</a>
                             </div>
                             <div class="card-body">
                                 @include('service_version_dependencies.show_fields')
                             </div>
                         </div>
                     </div>
                 </div>
          </div>
    </div>
@endsection
