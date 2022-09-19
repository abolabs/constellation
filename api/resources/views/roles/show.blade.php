@extends('layouts.app')


@section('content')
    <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('roles.index') }}">{{ __('role.title') }}</a>
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
                                <a href="{{ route('roles.index') }}" class="btn btn-light pull-right">{{ __('common.back') }}</a>
                            </div>
                            <div class="card-body">
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        {!! Form::label('name', \Lang::get('role.name')) !!}
                                        <p>{{ $role->name }}</p>
                                    </div>
                                    <hr class="my-2">
                                    <div class="form-group">
                                        {!! Form::label('Permissions', \Lang::get('role.permissions')) !!}
                                        <div class="form-group">
                                        @if(count($rolePermissions) > 0)
                                            @foreach($rolePermissions as $v)
                                                <div class="col-12">{{ $v->name }}</div>
                                            @endforeach
                                        @else
                                            <p> {{ __('role.no_permission') }}
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
