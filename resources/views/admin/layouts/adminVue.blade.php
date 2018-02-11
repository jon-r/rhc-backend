@extends('layouts.app')

@section('page')
  header
  @yield('content')
@endsection

@section('styles')
    {{ Html::style(mix('assets/admin/css/app.css')) }}
@endsection

@section('scripts')
    {{ Html::script(mix('assets/admin/js/app.js')) }}
@endsection
