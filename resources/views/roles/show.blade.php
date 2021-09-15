@extends('layouts.app')


@section('content')
    <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('roles.index') }}">Roles</a>
            </li>
            <li class="breadcrumb-item active">Detail</li>
     </ol>
     <div class="container-fluid">
          <div class="animated fadeIn">
                 @include('coreui-templates::common.errors')
                 <div class="row">
                     <div class="col-lg-12">
                         <div class="card">
                            <div class="card-header">
                                <strong>Details</strong>
                                <a href="{{ route('roles.index') }}" class="btn btn-light">Back</a>
                            </div>
                            <div class="card-body">
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        {!! Form::label('name', 'Name:') !!}
                                        <p>{{ $role->name }}</p>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">                                        
                                        {!! Form::label('Permissions', 'Permissions:') !!}
                                        @if(!empty($rolePermissions))
                                            @foreach($rolePermissions as $v)                                                
                                                <p>{{ $v->name }},</p>
                                            @endforeach
                                        @endif
                                </div>
                            </div>
                        </div>   
                    </div>    
                </div>
            </div>
        </div>
    </div>
@endsection