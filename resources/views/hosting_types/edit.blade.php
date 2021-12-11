@extends('layouts.app')

@section('content')
    <ol class="breadcrumb">
          <li class="breadcrumb-item">
             <a href="{!! route('hostingTypes.index') !!}">{{ __('hosting_type.title') }}</a>
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
                              <strong>{{ __('datatable.edit') }} {{ __('hosting_type.title') }}</strong>
                          </div>
                          <div class="card-body">
                              {!! Form::model($hostingType, ['route' => ['hostingTypes.update', $hostingType->id], 'method' => 'patch']) !!}

                              @include('hosting_types.fields')

                              {!! Form::close() !!}
                            </div>
                        </div>
                    </div>
                </div>
         </div>
    </div>
@endsection
