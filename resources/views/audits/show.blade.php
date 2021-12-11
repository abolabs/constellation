@extends('layouts.app')

@section('content')
     <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('audits.index') }}">{{ __('audit.title') }}</a>
            </li>
            <li class="breadcrumb-item active">{{ __('common.details') }}</li>
     </ol>
     <div class="container-fluid">
          <div class="animated fadeIn">
                 @include('coreui-templates::common.errors')
                 <div class="row">
                     <div class="col-lg-12">
                         <div class="card">
                             <div class="card-header text-white bg-secondary">
                                 <strong>{{ __('common.details') }}</strong>
                                  <a href="{{ route('audits.index') }}" class="btn btn-light">{{ __('common.back') }}</a>
                             </div>
                             <div class="card-body">
                                 @include('audits.show_fields')
                             </div>
                         </div>
                     </div>
                 </div>
          </div>
    </div>
@endsection
