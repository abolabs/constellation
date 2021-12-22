@extends('layouts.app')

@section('content')
    <ol class="breadcrumb">
        <li class="breadcrumb-item">{{ __('infra.service_instance_dependencies') }}</li>
    </ol>
    <div class="container-fluid">
        <div class="animated fadeIn">
             @include('flash::message')
             <div class="row">
                    <div class="col-lg-12">
                    @include('service_instance_dependencies.table')
                    </div>
             </div>
         </div>
    </div>
@endsection
