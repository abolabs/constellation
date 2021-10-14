@extends('layouts.app')


@section('content')
   <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="{!! route('users.index') !!}">Users</a>
        </li>
        <li class="breadcrumb-item active">Edit</li>
    </ol>

    <div class="container-fluid">
        <div class="animated fadeIn">
            @include('coreui-templates::common.errors')
            <div class="row">
                 <div class="col-lg-12">
                      <div class="card">
                          <div class="card-header text-white bg-secondary">
                              <i class="fa fa-edit fa-lg"></i>
                              <strong>Edit User</strong>
                          </div>
                        {!! Form::model($user, ['method' => 'PATCH','route' => ['users.update', $user->id]]) !!}
                          @include('users.fields')
                        {!! Form::close() !!}
                         </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
