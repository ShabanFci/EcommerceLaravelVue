@extends('layouts.app')

@section('css')
  <link rel="stylesheet" type="text/css" href="{{ mix('css/app.css') }}">
@endsection('css')

@section('js')
  <script type="text/javascript" src="{{ mix('js/app.js') }}"></script>
 
@endsection('js')

@section('content')

<div id="app">
</div>

@endsection('content')