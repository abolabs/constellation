@extends('layouts.app')



@section('content')
<ol class="breadcrumb">
    <li class="breadcrumb-item">
        Account
    </li>
    <li class="breadcrumb-item active">Settings</li>
</ol>
<div class="container-fluid">
    <div class="animated fadeIn">
        @include('coreui-templates::common.errors')
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header text-white bg-secondary">
                        <i class="fa fa-edit fa-lg"></i>
                        <strong>Edit profile</strong>
                    </div>
                    <div class="card-body">
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <strong>Language</strong>
                                <ul class="nav navbar-nav ml-auto">
                                    @php $locale = session()->get('locale'); @endphp
                                    <li class="nav-item dropdown">
                                        <a id="navbarDropdownlang" class="nav-link dropdown-toggle" href="#" role="button"
                                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                            @switch($locale)
                                                @case('en')
                                                <i class="flag-icon-us flag-icon "></i> English
                                                @break
                                                @case('fr')
                                                <i class="flag-icon-fr flag-icon "></i> Français
                                                @break
                                                @default
                                                <i class="flag-icon-fr flag-icon "></i> Français
                                            @endswitch
                                            <span class="caret"></span>
                                        </a>
                                        <div class="dropdown-menu" aria-labelledby="navbarDropdownlang">
                                            <a class="dropdown-item" href="lang/en"><i class="flag-icon-us flag-icon "></i> English</a>
                                            <a class="dropdown-item" href="lang/fr"><i class="flag-icon-fr flag-icon "></i> Français</a>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>

                        {!! Form::model($user, ['method' => 'PATCH','route' => 'user.updateSettings']) !!}
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <strong>Name:</strong>
                                {!! Form::text('name', null, array('placeholder' => 'Name','class' => 'form-control'))
                                !!}
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <strong>Email:</strong>
                                {!! Form::text('email', null, array('placeholder' => 'Email','class' => 'form-control'))
                                !!}
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <a class="btn btn-link px-0" href="{{ url('/password/reset') }}">{{ __('passwords.do_reset_title') }}</a>
                            </div>
                        </div>
                        <!-- Submit Field -->
                        <div class="form-group col-sm-12">
                            {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
                        </div>
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
