@extends('layouts.app')

@section('content')
<ol class="breadcrumb">
    <li class="breadcrumb-item">
        <a href="{{ route('services.index') }}">{{ __('infra.service') }}</a>
    </li>
    <li class="breadcrumb-item active">{{ __('common.details') }}</li>
</ol>
<div class="container-fluid">
    <div class="animated fadeIn">
        @include('coreui-templates::common.errors')
        <div class="row">
            <div class="col-lg-12">
                <h3>{{ $service->name }}</h3>
                <div class="card">
                    <div class="card-header text-white bg-secondary">
                        <strong>{{ __('common.details') }}</strong>
                        (<a href="{{ route('services.edit', $service->id ) }}" class="text-light">{{ __('datatable.edit') }}</a>)
                        <a href="{{ route('services.index') }}" class="btn btn-light pull-right">{{ __('common.back') }}</a>
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
                        <a class="pull-right" href="#" data-toggle="modal" data-target="#newVersionModal"><i
                                class="fa fa-plus-square fa-lg pull-right"></i></a>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            @foreach ($service->versions as $serviceVersion )
                            <div class="col-sm-6 col-md-4 col-lg-3">
                                <div class="card">
                                    @can("delete serviceVersion")
                                    {!! Form::open(['route' => ['serviceVersions.destroy', $serviceVersion->id], 'method' => 'delete']) !!}
                                    <div class="card-header text-white bg-primary">v. {{ $serviceVersion->version }}
                                        <input type="hidden" name="redirect_to_version" value="1" />
                                        @if (count($serviceByApplication[$serviceVersion->id]) == 0)
                                        <button type="submit" class="btn btn-transparent btn-sm pull-right" onclick="return confirm('{{ __('common.ask_confirm') }}')">
                                            <span class="badge badge-warning"><i class="fa fa-trash"></i></span>
                                        </button>
                                        @endif
                                    </div>
                                    {!! Form::close() !!}
                                    @endcan
                                    <div class="card-body">

                                        <div class="form-group">
                                            <!-- Created At Field -->
                                            {!! Form::label('created_at', \Lang::get('common.field_created_at')) !!}
                                            <p>{{ $serviceVersion->created_at }}</p>
                                            <!-- Updated At Field -->
                                            {!! Form::label('updated_at', \Lang::get('common.field_updated_at')) !!}
                                            <p>{{ $serviceVersion->updated_at }}</p>
                                        </div>

                                        @if(isset($serviceByApplication[$serviceVersion->id]))
                                        <hr class="my-2">
                                        <div class="form-group">
                                            {!! Form::label('application', \Lang::get('infra.nb_intances_per_app')) !!}
                                            <ul id="application" class="list-group">
                                                @forelse ($serviceByApplication[$serviceVersion->id] as $application_id
                                                => $application)
                                                <li
                                                    class="list-group-item d-flex justify-content-between align-items-center">
                                                    <a href="{{ route('applications.show', $application_id ) }}"
                                                        class="btn btn-light">{{$application['name']}}</a>
                                                    <span
                                                        class="badge badge-primary badge-pill">{{$application['total']}}</span>
                                                </li>

                                                @empty
                                                <p>n/a</p>
                                                @endforelse
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
<div class="modal fade" id="newVersionModal" tabindex="-1" role="dialog" aria-labelledby="newVersionModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h5 class="modal-title" id="newVersionModalLabel">{{ __('infra.new_version') }}</h5>
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
                <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('common.close') }}</button>
                {!! Form::submit(\Lang::get('common.save'), ['class' => 'btn btn-primary']) !!}
            </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>
@endsection
