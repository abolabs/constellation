<!DOCTYPE html>
<html lang="{{ Config::get('app.locale') }}">
<head>
    @include('layouts.head')
</head>
<body class="app flex-row align-items-center">
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card mx-4">
                <div class="card-body p-4">
                    @include('coreui-templates::common.errors')
                    <form method="post" action="{{ url('/password/reset') }}">
                        @csrf
                        <input type="hidden" name="token" value="{{ $token }}">
                        <h1>{{ __('passwords.do_reset_title') }}</h1>
                        <p class="text-muted">{{ __('passwords.do_reset_enter_email_password') }}</p>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text">@</span>
                            </div>
                            <input type="email" class="form-control {{ $errors->has('email')?'is-invalid':'' }}" name="email" value="{{ old('email') }}" placeholder="{{ __('auth.email_placeholder') }}">
                            @if ($errors->has('email'))
                                <span class="invalid-feedback">
                                    <strong>{{ $errors->first('email') }}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                              <span class="input-group-text">
                                <i class="icon-lock"></i>
                              </span>
                            </div>
                            <input type="password" class="form-control {{ $errors->has('password')?'is-invalid':''}}" name="password" placeholder="{{ __('auth.password_placeholder') }}">
                            @if ($errors->has('password'))
                                <span class="invalid-feedback">
                                    <strong>{{ $errors->first('password') }}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="input-group mb-4">
                            <div class="input-group-prepend">
                              <span class="input-group-text">
                                <i class="icon-lock"></i>
                              </span>
                            </div>
                            <input type="password" name="password_confirmation" class="form-control"
                                   placeholder="Confirm password">
                            @if ($errors->has('password_confirmation'))
                                <span class="help-block">
                                  <strong>{{ $errors->first('password_confirmation') }}</strong>
                               </span>
                            @endif
                        </div>
                        <button type="submit" class="btn btn-block btn-primary btn-block btn-flat">
                            <i class="fa fa-btn fa-refresh"></i> {{ __('passwords.do_reset_button') }}
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>
