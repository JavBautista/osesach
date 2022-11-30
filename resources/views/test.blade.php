@extends('layouts.app')

@section('content')
<div class="container">
   <!-- <example-component></example-component>
    <hr>

    <hr>
    <i class="bi bi-alarm"></i>

    <hr>
    -->
    <h2>IMAGEN TEST</h2>
    @if(Session::has('alert'))
        <p class="text-center alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('alert') }}</p>
    @endif

    <div class="row justify-content-center">

        <div class="col">
              <strong>Principal</strong>

              <form action="{{ route('test.upload')}}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                      <label for="test_image" class="form-label">Default file input example</label>
                      <input class="form-control" type="file" id="test_image" name="test_image">
                    </div>
                    <button type="submit" class="btn btn-primary">Upload</button>
              </form>
        </div> <!--./col-->


    </div>






</div>
@endsection
