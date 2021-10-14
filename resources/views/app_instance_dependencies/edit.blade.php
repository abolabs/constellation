@extends('layouts.app')

@section('content')
    <ol class="breadcrumb">
          <li class="breadcrumb-item">
             <a href="{!! route('appInstanceDependencies.index') !!}">App Instance Dependencies</a>
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
                              <strong>Edit App Instance Dependencies</strong>
                          </div>
                          <div class="card-body">
                              {!! Form::model($appInstanceDependencies, ['route' => ['appInstanceDependencies.update', $appInstanceDependencies->id], 'method' => 'patch']) !!}

                              @include('app_instance_dependencies.fields')

                              {!! Form::close() !!}
                            </div>
                        </div>
                    </div>
                </div>
         </div>
    </div>
@endsection
