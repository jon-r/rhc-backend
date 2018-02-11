@extends('admin.layouts.adminVue')

@section('content')

    <div id="v-app">
      <app-main></app-main>
    </div>

    <h3>{{ __('views.backend.section.navigation.sub_header_1') }}</h3>
    <ul class="nav side-menu">
        <li>
            <a href="{{ route('admin.users') }}">
                <i class="fa fa-users" aria-hidden="true"></i>
                {{ __('views.backend.section.navigation.menu_1_1') }}
            </a>
        </li>
        <li>
            <a href="{{ route('admin.permissions') }}">
                <i class="fa fa-key" aria-hidden="true"></i>
                {{ __('views.backend.section.navigation.menu_1_2') }}
            </a>
        </li>
    </ul>
@endsection

@section('scripts')
    @parent
    {{-- {{ Html::script(mix('assets/admin/js/dashboard.js')) }} --}}
@endsection

@section('styles')
    @parent
    {{-- {{ Html::style(mix('assets/admin/css/dashboard.css')) }} --}}
@endsection
