@extends('layouts.app')

@section('styles')
  <link href="https://use.fontawesome.com/releases/v5.0.6/css/all.css" rel="stylesheet">
@endsection

@section('page')
  @yield('content')
@endsection

@section('styles')
    {{-- {{ Html::style(mix('assets/admin/css/app.css')) }} --}}
@endsection

@section('scripts')
    {{ Html::script(mix('assets/admin/js/manifest.js')) }}
    {{ Html::script(mix('assets/admin/js/vendor.js')) }}
    {{ Html::script(mix('assets/admin/js/app.js')) }}
@endsection
