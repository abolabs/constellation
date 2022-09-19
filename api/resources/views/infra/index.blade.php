@extends('layouts.app')

@section('content')
<ol class="breadcrumb">
    <li class="breadcrumb-item">{{ __('infra.title') }}</li>
</ol>
<div class="container-fluid">
    <div class="animated fadeIn">
        @include('flash::message')

        <div class="row">
            @include('infra.items_count')
        </div>
        <!--/.row-->
        <div class="row">
            @include('infra.graph')
        </div>
        <!--/.row-->
    </div>
</div>
@endsection
