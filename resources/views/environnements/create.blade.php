@extends('layouts.app')

@section('content')
    <ol class="breadcrumb">
      <li class="breadcrumb-item">
         <a href="{!! route('environnements.index') !!}">{{ __('environnement.title') }}</a>
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
                                <strong>{{ __('datatable.create') }} {{ __('environnement.title') }}</strong>
                            </div>
                            <div class="card-body">
                                {!! Form::open(['route' => 'environnements.store']) !!}

                                   @include('environnements.fields')

                                {!! Form::close() !!}
                            </div>
                        </div>
                    </div>
                </div>
           </div>
    </div>
@endsection
