@extends('layouts.app')

@section('content')
     <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('services.index') }}">Service</a>
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
                                <a href="{{ route('services.edit', $service->id ) }}" class="btn btn-light">Edit</a>
                                <a href="{{ route('services.index') }}" class="btn btn-light pull-right">Back</a>
                             </div>
                             <div class="card-body row">
                                 @include('services.show_fields')
                             </div>
                         </div>
                     </div>
                 </div>
          </div>
    </div>
    <!-- Liste de versions -->
    <div class="container-fluid">
        <div class="animated fadeIn">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header text-white bg-secondary">
                            <strong>Version(s)</strong>
                            <a class="pull-right" href="#" data-toggle="modal" data-target="#newVersionModal"><i class="fa fa-plus-square fa-lg pull-right"></i></a>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                @foreach ($service->versions as $serviceVersion )
                                <div class="col-sm-6 col-md-4 col-lg-3">
                                    <div class="card">
                                        <div class="card-header text-white bg-primary">v. {{ $serviceVersion->version }} </div>
                                        <div class="card-body">
                                            <!-- Created At Field -->
                                            <div class="form-group">
                                                {!! Form::label('created_at', 'Created At') !!}
                                                <p>{{ $serviceVersion->created_at }}</p>
                                            </div>
                                            <hr class="my-2">

                                            <!-- Updated At Field -->
                                            <div class="form-group">
                                                {!! Form::label('updated_at', 'Updated At') !!}
                                                <p>{{ $serviceVersion->updated_at }}</p>
                                            </div>

                                            @if(isset($serviceByApplication[$serviceVersion->id]))
                                            <hr class="my-2">
                                            <div class="form-group">
                                                {!! Form::label('application', 'Nb instances par application') !!}
                                                <ul id="application" class="list-group">
                                                    @foreach ($serviceByApplication[$serviceVersion->id] as $application_id => $application)
                                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                                            <a href="{{ route('applications.show', $application_id ) }}" class="btn btn-light">{{$application['name']}}</a>
                                                            <span class="badge badge-primary badge-pill">{{$application['total']}}</span>
                                                        </li>
                                                    @endforeach

                                                </ul>
                                            </div>
                                            @endif
                                        </div>
                                      </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="newVersionModal" tabindex="-1" role="dialog" aria-labelledby="newVersionModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h5 class="modal-title" id="newVersionModalLabel">Nouvelle version</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            {!! Form::open(['route' => 'serviceVersions.store']) !!}
            <div class="modal-body">
                <!-- Service id -->
                <input type="hidden" name="service_id" value="{{ $service->id }}" />
                <input type="hidden" name="redirect_to_service" value="1" />
                <!-- Version Field -->
                <div class="form-group col-sm-6">
                    {!! Form::label('version', 'Version') !!}
                    {!! Form::text('version', null, ['class' => 'form-control']) !!}
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
            </div>
            {!! Form::close() !!}
        </div>
        </div>
    </div>
@endsection
