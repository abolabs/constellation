@extends('layouts.app')


@section('content')
<ol class="breadcrumb">
    <li class="breadcrumb-item">{{ __('user.title') }}</li>
</ol>
<div class="container-fluid">
    <div class="animated fadeIn">
        @include('flash::message')
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header text-white bg-secondary">
                        <a class="pull-right" href="{{ route('users.create') }}"><i
                                class="fa fa-plus-square fa-lg"></i></a>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered">
                            <caption>{{ __('user.caption') }}</caption>
                            <tr>
                                <th scope="col">{{ __('infra.id') }}</th>
                                <th scope="col">{{ __('infra.name') }}</th>
                                <th scope="col">{{ __('user.email') }}</th>
                                <th scope="col">{{ __('infra.roles') }}</th>
                                <th scope="col" width="280px">{{ __('datatable.action') }}</th>
                            </tr>
                            @foreach ($data as $key => $user)
                            <tr>
                                <td>{{ ++$i }}</td>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>
                                    @if(!empty($user->getRoleNames()))
                                    @foreach($user->getRoleNames() as $v)
                                    <label class="badge badge-success">{{ $v }}</label>
                                    @endforeach
                                    @endif
                                </td>
                                <td>
                                    <a class="btn btn-info" href="{{ route('users.show',$user->id) }}">{{
                                        __('datatable.view') }}</a>
                                    <a class="btn btn-primary" href="{{ route('users.edit',$user->id) }}">{{
                                        __('datatable.edit') }}</a>
                                    {!! Form::open(['method' => 'DELETE','route' => ['users.destroy',
                                    $user->id],'style'=>'display:inline']) !!}
                                    {!! Form::submit(\Lang::get('datatable.delete'), ['class' => 'btn btn-danger']) !!}
                                    {!! Form::close() !!}
                                </td>
                            </tr>
                            @endforeach
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div @endsection
