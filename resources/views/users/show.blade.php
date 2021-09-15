@extends('layouts.app')


@section('content')
    <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('users.index') }}">Users</a>
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
                                <a href="{{ route('users.index') }}" class="btn btn-light">Back</a>
                            </div>
                            <div class="card-body">
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        {!! Form::label('name', 'Name:') !!}
                                        {{ $user->name }}
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">                                        
                                        {!! Form::label('email', 'Email:') !!}
                                        {{ $user->email }}
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">                                        
                                        {!! Form::label('roles', 'Roles:') !!}
                                        @if(!empty($user->getRoleNames()))
                                            @foreach($user->getRoleNames() as $v)
                                                <label class="badge badge-success">{{ $v }}</label>
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
    </div>    
@endsection