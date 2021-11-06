@extends('layouts.app')

@section('content')
     <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('hostings.index') }}">Hosting</a>
            </li>
            <li class="breadcrumb-item active">Detail</li>
     </ol>
     <div class="container-fluid">
          <div class="animated fadeIn">
                 @include('coreui-templates::common.errors')
                 <div class="row">
                     <div class="col-lg-12">
                         <div class="card">
                             <div class="card-header text-white bg-secondary">
                                <strong>Details</strong>
                                <a href="{{ route('hostings.edit', $hosting->id ) }}" class="btn btn-light">Edit</a>
                                <a href="{{ route('hostings.index') }}" class="btn btn-light pull-right">Back</a>
                             </div>
                             <div class="card-body row">
                                 @include('hostings.show_fields')
                             </div>
                         </div>
                     </div>
                 </div>
          </div>
    </div>
@endsection
