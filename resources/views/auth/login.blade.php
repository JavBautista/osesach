@extends('auth.contenido')

@section('login')
<div class="row justify-content-center">
  <div class="col-md-8">
    <div class="card-group mb-0">
        <div class="card p-4">
          <form class="form-horizontal was-validated" method="POST" action="{{ route('login') }}">
            @csrf
            <div class="card-body">
                <img src="{{ asset('images/logo.jpeg') }}" width="80%" alt="Logo San Andres Cholula">
                <h1>Acceder</h1>
                <p class="text-muted">Control de acceso al sistema</p>

                    <div class="input-group mb-3">
                        <span class="input-group-addon"><i class="icon-user"></i></span>
                        <input id="email" type="email" name="email"  class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" placeholder="E-Mail" value="{{ old('email') }}" required autofocus>
                        @if ($errors->has('email'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('email') }}</strong>
                            </span>
                        @endif
                    </div>


                    <div class="input-group mb-4">
                        <span class="input-group-addon"><i class="icon-lock"></i></span>
                        <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required placeholder="Password">
                        @if ($errors->has('password'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('password') }}</strong>
                            </span>
                        @endif
                    </div>

                    <div class="form-group row">
                        <div class="col">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                <label class="form-check-label text-primary" for="remember">
                                    {{ __('Remember Me') }}
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-6">
                          <button type="submit" class="btn btn-primary px-4">Acceder</button>
                        </div>
                    </div>

            </div>
          </form>
        </div>

        <div class="card text-white bg-primary py-5 d-md-down-none" style="width:44%">
            <div class="card-body text-center">
              <div class="container">

                <h2>OSESACH v1.0.0</h2>

              </div>
            </div>
            <div class="card-fotter text-center">
                <p>2022 Ayuntamiento de San Andrés Cholula <br> Todos los derechos reservados.</p>
            </div>
        </div>

    </div>
  </div>
</div>
@endsection