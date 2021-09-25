@extends('layouts.app')

@section('content')
    <ol class="breadcrumb">
        <li class="breadcrumb-item">Environnements</li>
    </ol>
    <div class="container-fluid">
        <div class="animated fadeIn">
             @include('flash::message')
             <div class="row">
                    <div class="col-lg-12">
                        @include('environnements.table')
                    </div>
             </div>
         </div>
    </div>
@endsection

