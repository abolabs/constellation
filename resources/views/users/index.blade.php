@extends('layouts.app')


@section('content')
  <ol class="breadcrumb">
        <li class="breadcrumb-item">Users</li>
    </ol>
    <div class="container-fluid">
        <div class="animated fadeIn">
             @include('flash::message')
             <div class="row">            
                 <div class="col-lg-12">
                     <div class="card">
                         <div class="card-header">
                             <i class="fa fa-align-justify"></i>
                             Users
                             <a class="pull-right" href="{{ route('users.create') }}"><i class="fa fa-plus-square fa-lg"></i></a>
                         </div>
                         <div class="card-body">
                          <table class="table table-bordered">
                          <tr>
                            <th>No</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Roles</th>
                            <th width="280px">Action</th>
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
                                <a class="btn btn-info" href="{{ route('users.show',$user->id) }}">Show</a>
                                <a class="btn btn-primary" href="{{ route('users.edit',$user->id) }}">Edit</a>
                                  {!! Form::open(['method' => 'DELETE','route' => ['users.destroy', $user->id],'style'=>'display:inline']) !!}
                                      {!! Form::submit('Delete', ['class' => 'btn btn-danger']) !!}
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
    </div
@endsection