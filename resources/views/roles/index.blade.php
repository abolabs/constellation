@extends('layouts.app')


@section('content')

    <ol class="breadcrumb">
        <li class="breadcrumb-item">{{ __('infra.roles') }}</li>
    </ol>
    <div class="container-fluid">
        <div class="animated fadeIn">
             @include('flash::message')
             <div class="row">
                 <div class="col-lg-12">
                     <div class="card">
                         <div class="card-header text-white bg-secondary">
                             <i class="fa fa-align-justify"></i>
                             {{ __('infra.roles') }}
                             <a class="pull-right" href="{{ route('roles.create') }}"><i class="fa fa-plus-square fa-lg"></i></a>
                         </div>
                         <div class="card-body">
                            <table class="table table-bordered">
                                <caption> {{ __('role.caption') }}</caption>
                                <tr>
                                    <th scope="col">{{ __('infra.id') }}</th>
                                    <th scope="col">{{ __('infra.name') }}</th>
                                    <th scope="col" class="col-4">{{ __('datatable.action') }}</th>
                                </tr>
                                @foreach ($roles as $key => $role)
                                <tr>
                                    <td>{{ ++$i }}</td>
                                    <td>{{ $role->name }}</td>
                                    <td>
                                        <a class="btn btn-info" href="{{ route('roles.show',$role->id) }}">{{ __('datatable.view') }}</a>
                                        @can('role-edit')
                                            <a class="btn btn-primary" href="{{ route('roles.edit',$role->id) }}">{{ __('datatable.edit') }}</a>
                                        @endcan
                                        @can('role-delete')
                                            {!! Form::open(['method' => 'DELETE','route' => ['roles.destroy', $role->id],'style'=>'display:inline']) !!}
                                                {!! Form::submit(\Lang::get('datatable.delete'), ['class' => 'btn btn-danger']) !!}
                                            {!! Form::close() !!}
                                        @endcan
                                    </td>
                                </tr>
                                @endforeach
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
