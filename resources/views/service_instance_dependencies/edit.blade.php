@extends('layouts.app')

@section('content')
    <ol class="breadcrumb">
          <li class="breadcrumb-item">
             <a href="{!! route('serviceInstanceDependencies.index') !!}">Service Instance Dependencies</a>
          </li>
          <li class="breadcrumb-item active">Edit</li>
        </ol>
    <div class="container-fluid">
         <div class="animated fadeIn">
             @include('coreui-templates::common.errors')
             <div class="row">
                 <div class="col-lg-12">
                      <div class="card">
                          <div class="card-header text-white bg-secondary">
                              <i class="fa fa-edit fa-lg"></i>
                              <strong>Edit Service Instance Dependencies</strong>
                          </div>
                          <div class="card-body">
                              {!! Form::model($serviceInstanceDependencies, ['route' => ['serviceInstanceDependencies.update', $serviceInstanceDependencies->id], 'method' => 'patch']) !!}

                              @include('service_instance_dependencies.fields')

                              {!! Form::close() !!}
                            </div>
                        </div>
                    </div>
                </div>
         </div>
    </div>
@endsection
