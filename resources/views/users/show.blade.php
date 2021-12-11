@extends('layouts.app')


@section('content')
    <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('users.index') }}">{{ __('user.title') }}</a>
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
                                <a href="{{ route('users.index') }}" class="btn btn-light pull-right">{{ __('common.back') }}</a>
                            </div>
                            <div class="card-body">
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        {!! Form::label('name', \Lang::get('infra.name') ) !!}
                                        <p>{{ $user->name }}</p>
                                    </div>
                                </div>
                                <hr class="my-2">
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        {!! Form::label('email', \Lang::get('user.email')) !!}
                                        <p>{{ $user->email }}</p>
                                    </div>
                                </div>
                                <hr class="my-2">
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        {!! Form::label('roles', \Lang::get('infra.roles')) !!}
                                        <div>
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
    </div>
@endsection
