<!DOCTYPE html>
<html lang="{{ Config::get('app.locale') }}">
<head>
    @include('layouts.head')
</head>
<body class="app flex-row align-items-center">
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card-group">
                <div class="card p-4">
                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success">
                                {{ session('status') }}
                            </div>
                        @endif
                        <form method="post" action="{{ url('/password/email') }}">
                            @csrf
                            <h1>{{ __('passwords.reset_title') }}</h1>
                            <p class="text-muted">{{ __('passwords.enter_email') }}</p>
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

                            <div class="row">
                                <div class="col-6 offset-6">
                                    <button class="btn btn-block btn-primary" type="submit">
                                        <i class="fa fa-btn fa-envelope"></i> {{ __('passwords.send_password_reset_button') }}
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>
