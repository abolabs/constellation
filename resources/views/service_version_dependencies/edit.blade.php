@extends('layouts.app')

@section('content')
    <ol class="breadcrumb">
          <li class="breadcrumb-item">
             <a href="{!! route('serviceVersionDependencies.index') !!}">Service Version Dependencies</a>
          </li>
          <li class="breadcrumb-item active">Edit</li>
        </ol>
    <div class="container-fluid">
         <div class="animated fadeIn">
             @include('coreui-templates::common.errors')
             <div class="row">
                 <div class="col-lg-12">
                      <div class="card">
                          <div class="card-header">
                              <i class="fa fa-edit fa-lg"></i>
                              <strong>Edit Service Version Dependencies</strong>
                          </div>
                          <div class="card-body">
                              {!! Form::model($serviceVersionDependencies, ['route' => ['serviceVersionDependencies.update', $serviceVersionDependencies->id], 'method' => 'patch']) !!}

                              @include('service_version_dependencies.fields')

                              {!! Form::close() !!}
                            </div>
                        </div>
                    </div>
                </div>
         </div>
    </div>
@endsection