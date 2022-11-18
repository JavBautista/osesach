@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">OSESACH v0.1 {{ __('Dashboard') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    <p class="text-center">
                        <img src="{{ asset('images/logo.jpeg') }}" alt="OSESACH v0.1" width="150px">
                        <br>
                        {{ __('You are logged in!') }}
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
