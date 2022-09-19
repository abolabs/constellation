@extends('layouts.app')

@section('content')
    <ol class="breadcrumb">
          <li class="breadcrumb-item">
             <a href="{!! route('applications.index') !!}">{{ __('application.title') }}</a>
          </li>
          <li class="breadcrumb-item active">{{ __('datatable.edit') }}</li>
        </ol>
    <div class="container-fluid">
         <div class="animated fadeIn">
             @include('coreui-templates::common.errors')
             <div class="row">
                 <div class="col-lg-12">
                      <div class="card">
                          <div class="card-header text-white bg-secondary">
                              <i class="fa fa-edit fa-lg"></i>
                              <strong>{{ __('application.edit_application') }}</strong>
                          </div>
                          <div class="card-body">
                              {!! Form::model($application, ['route' => ['applications.update', $application->id], 'method' => 'patch']) !!}

                              @include('applications.fields')

                              {!! Form::close() !!}
                            </div>
                        </div>
                    </div>
                </div>
         </div>
    </div>
@endsection
