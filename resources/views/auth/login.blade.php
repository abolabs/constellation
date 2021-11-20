<!DOCTYPE html>
<html>
<head>
    @include('layouts.head')
</head>
<body class="app flex-row align-items-center">
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card-group">
                <div class="card p-4">
                    <div class="card-body">
                        <form method="post" action="{{ url('/login') }}">
                            @csrf
                            <h1>{{ __('auth.login') }}</h1>
                            <p class="text-muted">{{ __('auth.signin_title') }}</p>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">
                                      <i class="icon-user"></i>
                                    </span>
                                </div>
                                <input type="email" class="form-control {{ $errors->has('email')?'is-invalid':'' }}" name="email" value="{{ old('email') }}"
                                       placeholder="{{ __('auth.email_placeholder') }}">
                                @if ($errors->has('email'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="input-group mb-4">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">
                                      <i class="icon-lock"></i>
                                    </span>
                                </div>
                                <input type="password" class="form-control {{ $errors->has('password')?'is-invalid':'' }}" placeholder="{{ __('auth.password_placeholder') }}" name="password">
                                @if ($errors->has('password'))
                                    <span class="invalid-feedback">
                                       <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="row">
                                <div class="col-6">
                                    <button class="btn btn-primary px-4" type="submit">{{ __('auth.login') }}</button>
                                </div>
                                <div class="col-6 text-right">
                                    <a class="btn btn-link px-0" href="{{ url('/password/reset') }}">{!! __('auth.forgot_password') !!}</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="card text-white bg-primary py-5 d-md-down-none" style="width:44%">
                    <div class="card-body text-center">
                        <div>
                            <p>
                                <img class="login-logo" src="/img/abolabs_logo.png" alt="Abolabs Logo">
                            </p>
                            <h2>{{ __('auth.signup_title') }}</h2>
                            <p>{{ __('auth.signup_description') }}</p>
                                <a class="btn btn-primary active mt-3" href="{{ url('/register') }}">{{ __('auth.register_button') }}</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>
