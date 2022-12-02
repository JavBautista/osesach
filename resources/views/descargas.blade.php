@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">DESCARGAS</div>
                <div class="card-body text-center">
                    <a href="{{ asset('rsc/osesach_v1.apk') }}" target="_blank">
                        <i class="bi bi-download"></i> APP OSESACH v 1.0.0
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection