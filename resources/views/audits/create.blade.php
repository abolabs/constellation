@extends('layouts.app')

@section('content')
    <ol class="breadcrumb">
      <li class="breadcrumb-item">
         <a href="{!! route('audits.index') !!}">{{ __('audit.title') }}</a>
      </li>
      <li class="breadcrumb-item active">{{ __('datatable.create') }}</li>
    </ol>
     <div class="container-fluid">
          <div class="animated fadeIn">
                @include('coreui-templates::common.errors')
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-header text-white bg-secondary">
                                <i class="fa fa-plus-square-o fa-lg"></i>
                                <strong>{{ __('datatable.create') }} {{ __('audit.title') }}</strong>
                            </div>
                            <div class="card-body">
                                {!! Form::open(['route' => 'audits.store']) !!}

                                   @include('audits.fields')

                                {!! Form::close() !!}
                            </div>
                        </div>
                    </div>
                </div>
           </div>
    </div>
@endsection
